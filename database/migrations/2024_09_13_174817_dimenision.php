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
        Schema::create('dimension', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('product_id'); // Foreign key to products
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->string('general_dimensions')->nullable();
            $table->float('seat_height')->nullable();
            $table->float('arm_height')->nullable();
            $table->float('seat_depth')->nullable();
            $table->float('leg_height')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dimension');
    }
};
