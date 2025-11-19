<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('Products')) {
            Schema::create('Products', function (Blueprint $table) {
                $table->id('Id');
                $table->string('Name');
                $table->text('Description')->nullable();
                $table->decimal('Price', 10, 2);
                $table->decimal('Cost', 10, 2)->nullable();
                $table->integer('Stock')->default(0);
                $table->unsignedBigInteger('CategoryId')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('Products');
    }
};
