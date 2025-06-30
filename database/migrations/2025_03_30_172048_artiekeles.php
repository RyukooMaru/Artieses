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
        Schema::create('artiekeles', function (Blueprint $table) {
            $table->id('artiekelesid');
            $table->string('codekeles')->unique();
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            $table->string('judul')->nullable()->collation('utf8mb4_unicode_520_ci');
            $table->string('lseo')->nullable()->collation('utf8mb4_unicode_520_ci');
            $table->string('kseo')->nullable()->collation('utf8mb4_unicode_520_ci');
            $table->longtext('konten')->collation('utf8mb4_unicode_520_ci');
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
        Schema::dropIfExists('artiekeles');
    }
};
