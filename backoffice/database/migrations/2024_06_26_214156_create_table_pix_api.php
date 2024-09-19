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
        Schema::create('pix_api', function (Blueprint $table) {
            $table->id();
            $table->string('client_uuid');
            $table->string('txId');
            $table->string('order_id');
            $table->string('appId');
            $table->string('token');
            $table->string('amount');
            $table->string('external_reference');
            $table->enum('status', ['pending', 'approved', 'canceled'])->default('pending');
            $table->text('qrcode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pix_api');
    }
};
