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
            $table->foreignId('delivery_address')->nullable();
            $table->enum('status', [
                'draft',
                'accepted',
                'canceled',
                'ready',
                'delivered',
                'complete'
                ])->nullable();
            $table->double('amount')->nullable();
            $table->date('date')->nullable();
            $table->double('discount')->nullable();
            $table->double('extra_fee')->nullable();
            $table->enum('delivery',['yes', 'no'])->nullable();
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
