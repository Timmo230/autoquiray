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
        Schema::create('tests_have_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('test_id');
            $table->unsignedBigInteger('question_id');

            $table->foreign('test_id')->references('id')
            ->on('tests')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('question_id')->references('id')
            ->on('question_tests')->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['test_id', 'question_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests_have_questions');
    }
};
