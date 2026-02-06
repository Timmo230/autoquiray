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
        Schema::create('students_reserves_classes', function (Blueprint $table) {
            $table->string('student_id', 100);
            $table->unsignedBigInteger('class_id');

            $table->foreign('class_id')->references('id')
            ->on('classes')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('student_id')->references('user_id')
            ->on('students')->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['student_id', 'class_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_reserves_classes');
    }
};
