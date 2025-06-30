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
        Schema::create('banyakviewyah?emangiyah?', function (Blueprint $table) {
            $table->id('banyakviewyah?emangiyah?');
            $table->string('codevides');
            $table->foreign('codevides')->references('codevides')->on('artievides')->onDelete('cascade');
            $table->string('banyakviewyah?emangiyah?wkwk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banyakviewyah?emangiyah?');
    }
};
