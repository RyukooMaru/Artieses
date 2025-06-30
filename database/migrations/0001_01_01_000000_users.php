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
        Schema::create('users', function (Blueprint $table) {
            $table->id('userid');
            $table->string('username')->unique();
            $table->string('bio')->collation('utf8mb4_unicode_520_ci');
            $table->string('nameuse')->collation('utf8mb4_unicode_520_ci');
            $table->string('email')->unique();
            $table->string('password');
            $table->text('improfil')->nullable();
            $table->timestamp('editusername')->nullable();
            $table->timestamp('deleteaccount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
