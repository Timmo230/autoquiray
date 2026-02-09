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
        Schema::create('student_completes_tests', function (Blueprint $table) {
            $table->string('student_id', 100);
            $table->string('test_id', 100);
            $table->integer('last_note', false, true);

            $table->foreign('student_id')->references('user_id')
            ->on('students')->onUpdate('cascade')->onDelete('cascade');

             $table->foreign('test_id')->references('id')
            ->on('tests')->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['student_id', 'test_id']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_completes_tests');
    }
};
