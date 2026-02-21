<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->string('location');
            $table->string('location_type')->default('physical');
            $table->integer('capacity');
            $table->string('banner_image')->nullable();
            $table->string('category')->nullable();
            $table->uuid('organizer_id');
            $table->enum('status', ['draft', 'published', 'cancelled'])->default('draft');
            $table->timestamps();
            
            $table->foreign('organizer_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->index('status');
            $table->index('start_time');
            $table->index('organizer_id');
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
