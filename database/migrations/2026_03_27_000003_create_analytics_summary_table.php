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
        Schema::create('analytics_summary', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('total_page_views')->default(0);
            $table->integer('unique_visitors')->default(0);
            $table->integer('active_visitors')->default(0);
            $table->integer('new_visitors')->default(0);
            $table->decimal('avg_session_duration', 8, 2)->default(0); // dalam detik
            $table->timestamps();

            $table->unique('date');
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics_summary');
    }
};
