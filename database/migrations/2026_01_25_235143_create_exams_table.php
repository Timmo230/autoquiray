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
        Schema::create('exams', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->unsignedBigInteger('permission_id');
            $table->date('date');
            $table->time('start_time');
            $table->enum('type', ['theorist', 'practical']);
            $table->decimal('price');

            $table->foreign('permission_id')->references('id')
            ->on('permissions')->onUpdate('cascade')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
