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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("item_tag")->nullable();
            $table->string('name')->nullable();
            $table->double('price1')->nullable();
            $table->double('price2')->nullable();
            $table->double('price3')->nullable();
            $table->string('pic')->nullable();
            $table->string('description')->nullable();
            $table->double('quantity')->nullable();
            $table->double('minlevel')->nullable();
            $table->enum('unit', [
                'pcs', 'kg', 'meter', 'roll', 'liter', 'pack', 'box', 
                'set', 'pair', 'gallon', 'carton', 'dozen', 'sheet', 
                'bundle', 'tube', 'can', 'bag', 'barrel', 'foot', 
                'inch', 'yard', 'gram', 'millimeter', 'centimeter', 
                'square meter', 'cubic meter', 'ton'
            ])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
