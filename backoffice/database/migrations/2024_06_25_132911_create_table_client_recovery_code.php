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
        Schema::create('client_recovery_code', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->unique();
            $table->string('code', 7);
            $table->enum('status', ['used', 'new']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_recovery_code');
    }
};
