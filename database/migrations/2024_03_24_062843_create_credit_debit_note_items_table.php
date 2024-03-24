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
        Schema::create('credit_debit_note_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creditdebitnote_id')->nullable();
            $table->foreignId('item_id')->nullable();
            $table->double('quantity')->nullable();
            $table->double('price')->nullable();
            $table->double('amount')->nullable();
            $table->enum('unit',['sdf','sdsdf'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_debit_note_items');
    }
};
