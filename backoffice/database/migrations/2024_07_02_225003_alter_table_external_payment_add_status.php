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
        Schema::table('external_payment_pix', function (Blueprint $table) {
            $table->enum('status', ['paid', 'pending'])->nullable();
            $table->integer('expirationDate')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('external_payment', function (Blueprint $table) {
            //
        });
    }
};
