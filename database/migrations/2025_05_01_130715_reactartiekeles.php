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
        Schema::create('reactartiekeles', function (Blueprint $table) {
            $table->id('reactartiekelesid');
            $table->unsignedBigInteger('userid')->unique();
            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('artiekelesid');
            $table->foreign('artiekelesid')->references('artiekelesid')->on('artiekeles')->onDelete('cascade');
            $table->string('reaksi')->nullable()->collation('utf8mb4_unicode_520_ci');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactartiekeles');
    }
};
