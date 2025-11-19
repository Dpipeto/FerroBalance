<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('Customers')) {
            Schema::create('Customers', function (Blueprint $table) {
                $table->id('Id');
                $table->string('Name');
                $table->string('Email')->unique();
                $table->string('Phone')->nullable();
                $table->unsignedBigInteger('UserId')->nullable();
                $table->timestamps();
                $table->foreign('UserId')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('Customers');
    }
};
