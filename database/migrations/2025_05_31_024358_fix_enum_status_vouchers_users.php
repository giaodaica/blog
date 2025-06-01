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
       DB::statement("ALTER TABLE vouchers_users
        MODIFY COLUMN status ENUM('available', 'used', 'expired')
        NOT NULL DEFAULT 'available'");
    }

    /**
     * Reverse the migrations.
     */
   
};
