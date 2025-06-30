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
        Schema::create('dislikeartievides', function (Blueprint $table) {
            $table->id('dislikeartievidesid');
            $table->unsignedBigInteger('userid')->unique();
            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            $table->string('codevides');
            $table->foreign('codevides')->references('codevides')->on('artievides')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dislikeartiesvides');
    }
};
