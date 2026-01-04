<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->text("body");
            $table->foreignId("user_id")->constrained("users")->cascadeOnDelete();
            $table->foreignId("question_id")->constrained("questions")->cascadeOnDelete();
            $table->foreignId("parent_id")->nullable()->constrained("answers")->cascadeOnDelete();
            $table->unsignedInteger("total_replies_count")->default(0); // to record all replies count
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
