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
            $table->unsignedBigInteger('response_id');
            $table->foreign('response_id')->references('id')->on('responses')->cascadeOnDelete();
            $table->json('answer');
            $table->unsignedBigInteger('question_id'); // string for short and long / and array for remaining three to store the data of options
            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnDelete();
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
