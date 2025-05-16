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
        Schema::table('event_tests', function (Blueprint $table) {
            $table->integer('count_correct_answers');
            $table->json('specialization_ids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_tests', function (Blueprint $table) {
            $table->dropColumn('count_correct_answers');
            $table->dropColumn('specialization_ids');
        });
    }
};
