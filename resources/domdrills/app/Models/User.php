<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        "name",
        "email",
        "password",
        "role",
    ];

    protected $hidden = [
        "password",
        "remember_token",
    ];

    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === "admin";
    }

    public function isMentor(): bool
    {
        return in_array($this->role, ["mentor", "admin"]);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function threads()
    {
        return $this->hasMany(ForumThread::class);
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
