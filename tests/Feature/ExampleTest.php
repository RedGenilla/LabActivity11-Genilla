<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    // The homepage redirects visitors to the bulletin listing.
    public function test_homepage_redirects_to_posts(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/posts');
    }
}

