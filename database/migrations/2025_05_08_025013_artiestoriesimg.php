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
        Schema::create('artiestoriesimg', function (Blueprint $table) {
            $table->id('artiestoriesimgid');
            $table->unsignedBigInteger('artiestoriesid');
            $table->foreign('artiestoriesid')->references('artiestoriesid')->on('artiestories')->onDelete('cascade');
            $table->text('konten');
            $table->timestamp('deltime')->nullable();
            $table->string('delmode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artiestoriesimg');
    }
};
