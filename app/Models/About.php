<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'name',
        'profession',
        'profile_image',
        'description',
        'resume',
        'email',
        'phone',
        'location',
    ];
}
