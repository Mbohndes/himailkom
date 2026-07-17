<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'author_id', 'news_category_id', 'title', 'slug', 'excerpt', 'content', 
        'thumbnail', 'status', 'published_at', 'is_featured', 'is_breaking', 
        'allow_comments', 'meta_title', 'meta_description', 'meta_keywords', 'views_count'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_breaking' => 'boolean',
        'allow_comments' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(NewsTag::class);
    }
}