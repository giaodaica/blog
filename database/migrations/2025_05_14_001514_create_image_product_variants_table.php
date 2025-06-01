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
        Schema::create('image_product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_variant_id');
            $table->string('image_url_base')->nullable();
            $table->string('image_url_1')->nullable();
            $table->string('image_url_2')->nullable();
            $table->string('image_url_3')->nullable();
            $table->string('image_url_4')->nullable();
            $table->string('image_url_5')->nullable();
            $table->string('image_url_6')->nullable();
            $table->string('image_url_7')->nullable();
            $table->timestamps();
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_product_variants');
    }
};
