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
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('page_url');
            $table->string('page_title')->nullable();
            $table->string('visitor_ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id')->nullable();
            $table->string('device_type')->nullable(); // mobile, tablet, desktop
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->timestamp('viewed_at');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('visitor_ip');
            $table->index('session_id');
            $table->index('viewed_at');
            $table->index('page_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
