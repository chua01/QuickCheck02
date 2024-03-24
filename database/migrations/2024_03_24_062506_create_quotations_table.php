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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('billing_address')->nullable();
            $table->foreignId('delivery_address')->nullable();
            $table->enum('status', ['on going','complete'])->nullable();
            $table->double('amount')->nullable();
            $table->foreignId('issued_by')->nullable();
            $table->date('date')->nullable();
            $table->foreignId('payment_id')->nullable();
            $table->text('notes')->nullable();
            $table->double('discount')->nullable();
            $table->double('tax')->nullable();
            $table->double('extra_fee')->nullable();
            $table->double('delivery_fee')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
