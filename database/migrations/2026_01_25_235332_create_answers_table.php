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
            $table->string('teacher_id', 100)->nullable();
            $table->unsignedBigInteger('question_id');
            $table->string('menssage', 512);
            $table->dateTime('date_sent');

            $table->foreign('teacher_id')->references('employees_id')
            ->on('teachers')->onUpdate('cascade')->onDelete('set null');

            $table->foreign('question_id')->references('id')
            ->on('student_questions')->onUpdate('cascade')->onDelete('cascade');

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
