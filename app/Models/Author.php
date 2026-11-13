<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'email',
        'user_id',
    ];

    // An author profile belongs to a user account.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // One author can create many posts.
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    // Get comments received through the author's posts.
    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(
            Comment::class,
            Post::class,
            'author_id',
            'post_id'
        );
    }
}


