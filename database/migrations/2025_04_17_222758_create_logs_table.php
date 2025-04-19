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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['pending', 'disetujui', 'ditolak']);
            $table->text('feedback')->nullable();
            $table->boolean('is_resubmission')->default(false);
            $table->json('revision_history')->nullable();
            $table->string('attachment')->nullable();
            $table->string('original_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
