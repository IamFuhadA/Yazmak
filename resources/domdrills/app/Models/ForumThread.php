<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model
{
    protected $fillable = ["user_id", "title", "slug", "body", "is_resolved"];

    protected function casts(): array
    {
        return ["is_resolved" => "boolean"];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ForumReply::class)->oldest();
    }
}
