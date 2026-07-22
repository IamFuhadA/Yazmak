<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $fillable = ["name", "slug", "type", "created_by"];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class)->latest()->limit(100);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, "created_by");
    }
}
