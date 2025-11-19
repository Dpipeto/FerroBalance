<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('Payments')) {
            Schema::create('Payments', function (Blueprint $table) {
                $table->id('Id');
                $table->dateTime('PaymentDate');
                $table->decimal('Amount', 10, 2);
                $table->string('Method');
                $table->unsignedBigInteger('CreatedBy')->nullable();
                $table->unsignedBigInteger('InvoiceId')->nullable();
                $table->timestamps();
                $table->foreign('CreatedBy')->references('id')->on('users')->onDelete('set null');
                $table->foreign('InvoiceId')->references('Id')->on('Invoices')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('Payments');
    }
};
