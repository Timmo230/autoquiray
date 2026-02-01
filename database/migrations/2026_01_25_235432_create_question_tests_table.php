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
        Schema::create('question_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->string('title');
            $table->unsignedBigInteger('correct_option_id')->nullable();

            $table->foreign('teacher_id')->references('employees_id')
            ->on('teachers')->onUpdate('cascade')->onDelete('set null');

            $table->foreign('test_id')->references('id')
            ->on('tests')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_tests');
    }
};
