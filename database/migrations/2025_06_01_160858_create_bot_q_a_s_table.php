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
        Schema::create('bot_q_a_s', function (Blueprint $table) {
            $table->id();
            $table->string('question'); // câu hỏi mẫu
            $table->text('answer');     // câu trả lời
            $table->string('keywords')->nullable(); // từ khóa tách nhau bởi dấu phẩy
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_q_a_s');
    }
};
