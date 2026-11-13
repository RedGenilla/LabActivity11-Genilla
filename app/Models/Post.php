<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'category',
        'body',
        'is_published',
        'is_pinned',
        'published_at',
        'views',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_pinned' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Each post belongs to one author.
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    // Each post can receive many comments.
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Posts can have multiple tags.
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
}


