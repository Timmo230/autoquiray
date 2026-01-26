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
        Schema::create('tutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('administrator_id')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('permission_id');
            $table->date('date');
            $table->date('start_date');
            $table->date('max_end_date');
            $table->enum('status', ['pendientePago', 'matriculado', 'expirado', 'finalizado']);
            $table->decimal('price');

            $table->foreign('administrator_id')->references('employees_id')
            ->on('administrators')->onUpdate('cascade')->onDelete('set null');

            $table->foreign('student_id')->references('user_id')
            ->on('students')->onUpdate('cascade')->onDelete('restrict');

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
        Schema::dropIfExists('tutions');
    }
};
