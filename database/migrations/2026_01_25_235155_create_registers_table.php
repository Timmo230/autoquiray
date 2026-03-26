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
        Schema::create('registers', function (Blueprint $table) {
            $table->string('student_id', 100);
            $table->string('exam_id', 100);
            $table->integer('note', false, true)->nullable();

            $table->primary(['student_id', 'exam_id']);

            $table->foreign('student_id')->references('user_id')
            ->on('students')->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('exam_id')->references('id')->on('exams')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registers');
    }
};
