<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE orders 
        MODIFY COLUMN pay_method ENUM('COD', 'QR', 'VNPAY') 
        NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE orders 
        MODIFY COLUMN pay_method ENUM('COD', 'QR') 
        NULL");
    }
}; 