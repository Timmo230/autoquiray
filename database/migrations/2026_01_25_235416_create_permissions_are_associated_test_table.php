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
        Schema::create('permissions_are_associated_test', function (Blueprint $table) {
            $table->string('test_id', 100);
            $table->unsignedBigInteger('permission_id');

            $table->foreign('test_id')->references('id')
            ->on('tests')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('permission_id')->references('id')
            ->on('permissions')->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['test_id', 'permission_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions_are_associated_test');
    }
};
