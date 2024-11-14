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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('customerName');
            $table->string('customerPhone');
            $table->string('customerCompany')->nullable();
            $table->string('customerAddress')->nullable();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('ProductSalePrice', 12, 2);
            $table->integer('SaleQunatity');
            $table->string('InvoiceNumber');
            $table->string('InvoiceDate');
            $table->decimal('InvoiceTotal', 12, 0);
            $table->decimal('InvoicePaid', 12, 0)->nullable();
            $table->decimal('InvoiceDue', 12, 0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
