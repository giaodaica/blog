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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_variants_id')->unique();
            $table->unsignedBigInteger('flash_sale_items_id')->unique()->nullable();
            $table->integer('quantity');
            $table->decimal('price_at_time', 10, 2);
            $table->enum('promotion_type', ['0', 'flash_sale', 'bundle'])->default('0');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_variants_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->foreign('flash_sale_items_id')->references('id')->on('flash_sale_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
