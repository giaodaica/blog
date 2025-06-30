<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('total_spent', 15, 2)->default(0)->after('role');
            $table->unsignedInteger('point')->default(0)->after('total_spent');
            $table->enum('rank', ['newbie', 'silver', 'gold', 'diamond'])->default('newbie')->after('point');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['total_spent', 'point', 'rank']);
        });
    }
};
