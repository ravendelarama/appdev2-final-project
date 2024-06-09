<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
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

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function replies()
    {
        return $this->belongsToMany(Reply::class, 'replies', 'children_id', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsToMany(Reply::class, 'replies', 'parent_id', 'children_id');
    }

    public function quotes()
    {
        return $this->belongsToMany(Quote::class, 'quotes', 'quote_id', 'reference_id');
    }

    public function quoteOrigin()
    {
        return $this->belongsToMany(Quote::class, 'quotes', 'reference_id', 'quote_id');
    }
}
