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
        Schema::create('rcm1story', function (Blueprint $table) {
            $table->id('rcm1storyid');
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('commentartiestoriesid')->unique();
            $table->foreign('commentartiestoriesid')->references('commentartiestoriesid')->on('commentartiestories')->onDelete('cascade');
            $table->string('reaksi')->nullable()->collation('utf8mb4_unicode_520_ci');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rcm1story');
    }
};
