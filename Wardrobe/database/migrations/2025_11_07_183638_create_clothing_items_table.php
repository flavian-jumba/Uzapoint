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
        Schema::create('clothing_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->string('brand')->nullable();
            $table->string('size')->nullable();
            $table->string('image')->nullable(); // Changed from image_url to image for file upload
            $table->decimal('price', 10, 2)->nullable();
            $table->string('season')->nullable(); // Spring, Summer, Fall, Winter, All Season
            $table->string('condition')->nullable(); // New, Like New, Good, Fair
            $table->date('purchase_date')->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clothing_items');
    }
};
