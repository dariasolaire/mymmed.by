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
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('slide_image')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('h1');
            $table->text('text')->nullable();
            $table->text('issue')->nullable();
            $table->json('tasks')->nullable();
            $table->integer('president')->nullable();
            $table->json('council')->nullable();
            $table->json('contacts')->nullable();
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
        Schema::dropIfExists('associations');
    }
};
