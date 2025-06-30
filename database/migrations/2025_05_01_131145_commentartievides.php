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
        Schema::create('commentartievides', function (Blueprint $table) {
            $table->id('commentartievidesid');
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            $table->string('codevides');
            $table->foreign('codevides')->references('codevides')->on('artievides')->onDelete('cascade');
            $table->longtext('commentses')->collation('utf8mb4_unicode_520_ci');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentartievides');
    }
};
