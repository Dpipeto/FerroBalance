<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('InvoiceLines')) {
            Schema::create('InvoiceLines', function (Blueprint $table) {
                $table->id('Id');
                $table->unsignedBigInteger('InvoiceId');
                $table->unsignedBigInteger('ProductId');
                $table->integer('Cantidad');
                $table->decimal('Precio', 10, 2);
                $table->decimal('Descuento', 10, 2)->default(0);
                $table->foreign('InvoiceId')->references('Id')->on('Invoices')->onDelete('cascade');
                $table->foreign('ProductId')->references('Id')->on('Products')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('InvoiceLines');
    }
};
