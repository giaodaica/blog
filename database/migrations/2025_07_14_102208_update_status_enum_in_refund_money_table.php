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
        Schema::table('refund_money', function (Blueprint $table) {
            DB::statement("ALTER TABLE refund_money
        MODIFY COLUMN status ENUM('pending', 'approved', 'rejected','admin') NOT NULL DEFAULT 'admin'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refund_money', function (Blueprint $table) {
            //
        });
    }
};
