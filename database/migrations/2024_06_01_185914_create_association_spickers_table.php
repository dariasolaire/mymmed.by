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
        Schema::create('association_spickers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('association_id')
                ->constrained('associations')
                ->cascadeOnDelete();
            $table->foreignId('spicker_id')
                ->constrained('spickers')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('association_spickers');
    }
};
