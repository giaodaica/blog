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
  public function up()
{
    DB::statement("ALTER TABLE vouchers
        MODIFY COLUMN status ENUM('draft', 'active', 'disabled', 'used_up', 'expired', 'revoked')
        NOT NULL DEFAULT 'draft'");
}


};
