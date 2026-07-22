<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = [
        "user_id", "symbol", "direction", "entry_price", "exit_price",
        "quantity", "entry_date", "exit_date", "pnl", "setup", "notes",
    ];

    protected function casts(): array
    {
        return [
            "entry_date" => "date",
            "exit_date" => "date",
            "entry_price" => "decimal:4",
            "exit_price" => "decimal:4",
            "quantity" => "decimal:4",
            "pnl" => "decimal:4",
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isOpen(): bool
    {
        return is_null($this->exit_price);
    }
}
