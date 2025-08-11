<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_habits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('habit_id')->nullable()->constrained('habits')->nullOnDelete();
            $table->string('custom_title')->nullable();
            $table->text('custom_desc')->nullable();
            $table->string('color', 20)->nullable();
            $table->string('question')->nullable();
            $table->string('unit')->nullable();
            $table->unsignedInteger('target')->nullable();
            $table->enum('target_type', ['at_least', 'at_most', 'exact'])->default('at_least');
            $table->enum('frequency', ['daily', 'weekly', 'monthly'])->default('daily');
            $table->string('reminder_time')->nullable();
            $table->text('notes')->nullable();
            $table->date('start_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_habits');
    }
};
