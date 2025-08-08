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
            $table->foreignId('habit_id')->nullable()->constrained('habits')->onDelete('set null');
            $table->string('custom_title')->nullable(); // اگر habit پیش‌فرض نبود
            $table->string('custom_desc')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('start_date')->nullable();
            $table->enum('frequency', ['daily', 'weekly', 'monthly'])->default('daily');
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
