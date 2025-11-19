<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('Invoices')) {
            Schema::create('Invoices', function (Blueprint $table) {
                $table->id('Id');
                $table->string('InvoiceNumber')->unique();
                $table->unsignedBigInteger('CustomerId');
                $table->dateTime('Date');
                $table->dateTime('DueDate')->nullable();
                $table->decimal('Subtotal', 10, 2);
                $table->decimal('Tax', 10, 2);
                $table->decimal('Total', 10, 2);
                $table->string('Status')->default('Pendiente');
                $table->unsignedBigInteger('CreatedBy')->nullable();
                $table->timestamps();
                $table->foreign('CustomerId')->references('Id')->on('Customers')->onDelete('cascade');
                $table->foreign('CreatedBy')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('Invoices');
    }
};
