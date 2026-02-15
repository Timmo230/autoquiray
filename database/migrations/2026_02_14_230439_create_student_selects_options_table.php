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
        Schema::create('student_selects_options', function (Blueprint $table) {
            $table->string('student_id', 100);
            $table->string('option_id', 100);

            $table->primary(['student_id', 'option_id']);

            $table->foreign('student_id')->references('user_id')
            ->on('students')->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('option_id')->references('id')->on('options')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_selects_options');
    }
};
