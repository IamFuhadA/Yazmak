<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        "user_id", "category_id", "title", "slug",
        "excerpt", "body", "cover_image", "published_at",
    ];

    protected function casts(): array
    {
        return [
            "published_at" => "datetime",
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull("published_at")->where("published_at", "<=", now());
    }
}
