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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('visitor_ip');
            $table->string('user_agent')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('device_type')->nullable(); // mobile, tablet, desktop
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->integer('page_views_count')->default(1);
            $table->timestamp('first_visit_at');
            $table->timestamp('last_visit_at');
            $table->timestamp('last_activity_at');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('visitor_ip');
            $table->index('session_id');
            $table->index('last_activity_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
