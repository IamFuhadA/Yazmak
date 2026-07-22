<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("trades", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->string("symbol");
            $table->enum("direction", ["long", "short"])->default("long");
            $table->decimal("entry_price", 15, 4);
            $table->decimal("exit_price", 15, 4)->nullable();
            $table->decimal("quantity", 15, 4);
            $table->date("entry_date");
            $table->date("exit_date")->nullable();
            $table->decimal("pnl", 15, 4)->nullable();
            $table->string("setup")->nullable();
            $table->text("notes")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("trades");
    }
};
