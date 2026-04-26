<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_questions', function (Blueprint $table) {
            $table->renameColumn('menssage', 'message');
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->renameColumn('menssage', 'message');
        });
    }

    public function down(): void
    {
        Schema::table('student_questions', function (Blueprint $table) {
            $table->renameColumn('message', 'menssage');
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->renameColumn('message', 'menssage');
        });
    }
};
