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
        Schema::create('order_credit', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->float('amount');
            $table->json('purchase_info');
            $table->json('response');
            $table->string('external_reference');
            $table->string('order_id')->nullable();
            $table->enum('status', ['error', 'denied', 'cancelled', 'pre_authorized', 'captured', 'processing', 'paid']);
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('client')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_credit');
    }
};
