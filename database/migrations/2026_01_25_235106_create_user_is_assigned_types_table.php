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
        Schema::create('user_is_assigned_types', function (Blueprint $table) {
            $table->string('user_id', 100);
            $table->unsignedBigInteger('type_id');
            $table->timestamps();

            $table->primary(['user_id', 'type_id']);

            $table->foreign('user_id')->references('id')
            ->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('type_id')->references('id')->on('types')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_is_assigned_types');
    }
};
