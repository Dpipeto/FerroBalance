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
        if (!Schema::hasTable('Users')) {
            Schema::create('Users', function (Blueprint $table) {
                $table->id('IdUsers');
                $table->string('FirstName');
                $table->string('LastName');
                $table->string('Email')->unique();
                $table->string('Password');
                $table->rememberToken();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Users');
    }
};
