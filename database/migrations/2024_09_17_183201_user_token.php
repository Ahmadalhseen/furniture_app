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
        Schema::create('user_token', function (Blueprint $table) {
            $table->id();
            $table->string('token', 300);
            $table->unsignedBigInteger('user_id'); // Correct the foreign key type
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Ensure foreign key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_token');
    }
};
