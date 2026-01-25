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
        Schema::create('permissions_are_tought_in_classes', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('permission_id');

            $table->foreign('class_id')->references('id')
            ->on('classes')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('permission_id')->references('id')
            ->on('permissions')->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['class_id', 'permission_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions_are_tought_in_classes');
    }
};
