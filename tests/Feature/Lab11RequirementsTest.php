<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class Lab11RequirementsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Avoid requiring a running Vite server in tests.
        $this->withoutVite();

        // Seed the isolated test database.
        $this->seed();
    }

    public function test_database_and_personalization(): void
    {
        $this->assertTrue(Schema::hasTable('comments'));
        $this->assertTrue(Schema::hasTable('tags'));
        $this->assertTrue(Schema::hasTable('post_tag'));
        $this->assertTrue(
            Schema::hasColumn('authors', 'user_id')
        );

        $this->assertSame(10, User::count());
        $this->assertSame(5, Author::count());
        $this->assertSame(51, Post::count());
        $this->assertSame(5, Tag::count());

        $this->assertSame(
            41,
            Post::where('is_published', true)->count()
        );

        $this->assertEqualsCanonicalizing(
            [
                'Purok Genilla',
                'Urgent',
                'Libre',
                'Schedule',
                'Events',
            ],
            Tag::pluck('name')->all()
        );
    }

    public function test_seeded_accounts(): void
    {
        $kagawad = User::where(
            'email',
            'kagawad.genilla@bulletin.test'
        )->firstOrFail();

        $lola = User::where(
            'email',
            'lola.genilla@bulletin.test'
        )->firstOrFail();

        $this->assertSame(
            'Red Genilla',
            $kagawad->author()->firstOrFail()->name
        );

        $this->assertTrue(
            Hash::check('bulletin2026', $kagawad->password)
        );

        $this->assertTrue(
            Hash::check('bulletin2026', $lola->password)
        );

        $this->assertNull($lola->author);
    }

    public function test_personalized_pinned_post(): void
    {
        $post = Post::where('is_pinned', true)
            ->firstOrFail();

        $this->assertSame(
            'Purok Genilla Clean-up Drive',
            $post->title
        );

        $this->assertSame(
            '2026-09-15',
            $post->published_at->format('Y-m-d')
        );

        $this->assertEqualsCanonicalizing(
            ['Purok Genilla', 'Urgent'],
            $post->tags()->pluck('name')->all()
        );

        $this->assertGreaterThanOrEqual(
            3,
            $post->comments()->count()
        );

        $lola = User::where(
            'email',
            'lola.genilla@bulletin.test'
        )->firstOrFail();

        $this->assertTrue(
            $post->comments()
                ->where('user_id', $lola->id)
                ->exists()
        );
    }

    public function test_public_bulletin_pages(): void
    {
        $this->get('/')
            ->assertRedirect('/posts');

        $this->get('/posts')
            ->assertOk()
            ->assertSee('Barangay Bulletin');

        $this->get('/posts?tag=Urgent')
            ->assertOk()
            ->assertSee('Purok Genilla Clean-up Drive');

        $author = Author::where(
            'email',
            'kagawad.genilla@bulletin.test'
        )->firstOrFail();

        $this->get('/authors/' . $author->id)
            ->assertOk()
            ->assertSee('comments received');
    }

    public function test_resident_cannot_create_posts(): void
    {
        $this->get('/posts/create')
            ->assertRedirect('/login');

        $lola = User::where(
            'email',
            'lola.genilla@bulletin.test'
        )->firstOrFail();

        $this->actingAs($lola);

        $this->get('/posts/create')
            ->assertForbidden();

        $this->post('/posts', [
            'title' => 'Resident Attempt',
            'body' => 'Residents cannot publish this announcement.',
            'category' => 'Events',
            'tags' => [Tag::firstOrFail()->id],
        ])->assertForbidden();
    }

    public function test_kagawad_can_publish_posts(): void
    {
        $kagawad = User::where(
            'email',
            'kagawad.genilla@bulletin.test'
        )->firstOrFail();

        $tagIds = Tag::whereIn('name', [
            'Purok Genilla',
            'Schedule',
        ])->pluck('id')->all();

        $this->actingAs($kagawad);

        $this->get('/posts/create')
            ->assertOk();

        $this->post('/posts', [
            'title' => 'Purok Genilla Community Meeting',
            'body' => 'All residents are invited to our upcoming community meeting.',
            'category' => 'Events',
            'tags' => $tagIds,
            'is_published' => '1',
        ])->assertSessionHasNoErrors();

        $post = Post::where(
            'title',
            'Purok Genilla Community Meeting'
        )->firstOrFail();

        $this->assertTrue($post->is_published);
        $this->assertNotNull($post->published_at);

        $this->assertSame(
            $kagawad->author()->firstOrFail()->id,
            $post->author_id
        );

        $this->assertEqualsCanonicalizing(
            $tagIds,
            $post->tags()->pluck('tags.id')->all()
        );
    }

    public function test_kagawad_can_save_drafts(): void
    {
        $kagawad = User::where(
            'email',
            'kagawad.genilla@bulletin.test'
        )->firstOrFail();

        $this->actingAs($kagawad);

        $this->post('/posts', [
            'title' => 'Draft Notice',
            'body' => 'This announcement is being saved as a draft.',
            'category' => 'Events',
            'tags' => [Tag::firstOrFail()->id],
        ])->assertRedirect('/posts');

        $post = Post::where(
            'title',
            'Draft Notice'
        )->firstOrFail();

        $this->assertFalse($post->is_published);
        $this->assertNull($post->published_at);

        $this->get('/posts/' . $post->id)
            ->assertNotFound();
    }

    public function test_comment_submission_and_validation(): void
    {
        $lola = User::where(
            'email',
            'lola.genilla@bulletin.test'
        )->firstOrFail();

        $post = Post::where('is_pinned', true)
            ->firstOrFail();

        $before = $post->comments()->count();

        $this->actingAs($lola);

        $this->post(
            '/posts/' . $post->id . '/comments',
            ['body' => 'Thank you for organizing!']
        )->assertSessionHasNoErrors();

        $this->assertSame(
            $before + 1,
            $post->comments()->count()
        );

        $this->assertTrue(
            Comment::where('post_id', $post->id)
                ->where('user_id', $lola->id)
                ->where('body', 'Thank you for organizing!')
                ->exists()
        );

        $this->post(
            '/posts/' . $post->id . '/comments',
            ['body' => 'Hi']
        )->assertSessionHasErrors('body');
    }
}
