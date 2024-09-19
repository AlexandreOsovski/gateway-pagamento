<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->references('id')->on('client')->onDelete('cascade');
            $table->string('method_payment');
            $table->string('type_key');
            $table->decimal('amount', 10, 2);
            $table->string('address')->nullable();
            $table->string('token')->nullable();
            $table->string('status');
            $table->boolean('approved_manual')->default(false);
            $table->boolean('confirm')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};