<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('balcomvides', function (Blueprint $table) {
            $table->id('balcomvidesid');
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('commentartievidesid');
            $table->foreign('commentartievidesid')->references('commentartievidesid')->on('commentartievides')->onDelete('cascade');
            $table->string('comment')->nullable()->collation('utf8mb4_unicode_520_ci');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balcomvides');
    }
};
