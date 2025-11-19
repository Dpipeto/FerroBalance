<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('UserRoles')) {
            Schema::create('UserRoles', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('UserId');
                $table->unsignedBigInteger('RoleId');
                $table->foreign('UserId')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('RoleId')->references('Id')->on('Roles')->onDelete('cascade');
                $table->unique(['UserId', 'RoleId']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('UserRoles');
    }
};
