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
        Schema::create('product', function (Blueprint $table) {
            $table->id(); // Primary key for the product table
            $table->string('p_name'); // Product name
            $table->decimal('p_price', 8, 2); // Product price
            $table->string('main_image'); // Main product image
            $table->unsignedBigInteger('cat_id'); // Foreign key for category
            $table->text('description')->nullable(); // Description of the product
            $table->string('color')->nullable(); // Product color
            $table->string('material')->nullable(); // Material type
            $table->string('fabric')->nullable(); // Fabric type

            $table->timestamps(); // created_at and updated_at

            // Foreign key constraints
            $table->foreign('cat_id')
                ->references('id')->on('categorie') // Assuming table name is "categories"
                ->onDelete('cascade'); // If a category is deleted, products in that category are deleted


                
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
