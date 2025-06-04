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
        Schema::create('flash_sale_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_variant_id')->unique();
            $table->unsignedBigInteger('flash_sale_id');
            $table->string('name');
            $table->string('variant_image_url');
            $table->integer('max_quantity');
            $table->integer('sold_quantity');
            $table->decimal('price_at_flash_sale', 10, 2);
            $table->timestamps();
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->foreign('flash_sale_id')->references('id')->on('flash_sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_sale_items');
    }
};
