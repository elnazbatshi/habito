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
        Schema::create('habit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_habit_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['completed', 'skipped', 'missed'])->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Prevent duplicate logs for same habit on same date
            $table->unique(['user_habit_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_logs');
    }
};
