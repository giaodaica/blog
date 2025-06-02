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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('flash_sale_items_id');
            $table->unsignedBigInteger('product_variant_id');
            $table->integer('quantity');
            $table->decimal('price_at_time', 10, 2);
            $table->timestamps();
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->enum('promotion_type', ['0', 'flash_sale', 'bundle'])->default('0');
            $table->foreign('flash_sale_items_id')->references('id')->on('flash_sale_items')->onDelete('cascade');
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
