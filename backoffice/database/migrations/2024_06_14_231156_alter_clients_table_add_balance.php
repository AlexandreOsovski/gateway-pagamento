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
        Schema::table('client', function (Blueprint $table) {
            $table->float("balance", 32)->nullable()->default(0.00)->after("uuid");
            $table->float("balance_usdt", 32)->nullable()->default(0.00)->after("balance");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client', function (Blueprint $table) {
            $table->dropColumn("balance", 32);
            $table->dropColumn("balance_usdt", 32);
        });
    }
};