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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialization_id')
                ->constrained('specializations')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('description');
            $table->string('slug')->unique();
            $table->text('text')->nullable();
            $table->unsignedInteger('type');
            $table->date('date_start')->nullable();
            $table->time('time_start')->nullable();
            $table->date('date_end')->nullable();
            $table->time('time_end')->nullable();
            $table->string('place')->nullable();
            $table->json('main_theme')->nullable();
            $table->json('theses')->nullable();
            $table->boolean('is_active')->default(false);
            $table->index('slug');
            $table->index('is_active');
            $table->index('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
