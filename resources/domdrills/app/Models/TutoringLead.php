<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutoringLead extends Model
{
    protected $fillable = ["user_id", "name", "email", "phone", "plan", "message", "status"];
}
