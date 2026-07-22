<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("tutoring_leads", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained()->nullOnDelete();
            $table->string("name");
            $table->string("email");
            $table->string("phone")->nullable();
            $table->string("plan")->default("General Enquiry");
            $table->text("message")->nullable();
            $table->enum("status", ["new", "contacted", "scheduled", "closed"])->default("new");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("tutoring_leads");
    }
};
