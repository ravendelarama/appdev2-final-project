<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'caption',
        'view_count',
        'hide_like_and_share'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function reposts()
    {
        return $this->hasMany(Repost::class);
    }

    public function replies()
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    public function parentPost()
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    public function quotePosts()
    {
        return $this->hasMany(Post::class, 'quote_id');
    }

    public function quotedPost()
    {
        return $this->belongsTo(Post::class, 'quote_id');
    }
}
