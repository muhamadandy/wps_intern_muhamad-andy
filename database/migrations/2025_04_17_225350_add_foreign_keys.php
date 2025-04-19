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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('position_id')
                  ->references('id')
                  ->on('positions');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('manager_id')
                  ->references('id')
                  ->on('users');
        });

        Schema::table('logs', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropForeign(['position_id']);
        });
    }
};