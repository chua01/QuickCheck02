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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('issued_by')->nullable();
            $table->foreignId('reference_id')->nullable();
            $table->enum('reference_type',['table1','table2'])->nullable();
            $table->enum('status',['complete','sdf'])->nullable();
            $table->enum('payment_method',['complete','sdf'])->nullable();
            $table->double('amount')->nullable();
            $table->string('received_from')->nullable();
            $table->date('payment_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
