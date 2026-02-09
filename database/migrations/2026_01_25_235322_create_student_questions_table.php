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
        Schema::create('student_questions', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('student_id', 100)->nullable();
            $table->string('menssage', 512);
            $table->dateTime('date_sent');
            $table->string('affair');

            $table->foreign('student_id')->references('user_id')
            ->on('students')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_questions');
    }
};
