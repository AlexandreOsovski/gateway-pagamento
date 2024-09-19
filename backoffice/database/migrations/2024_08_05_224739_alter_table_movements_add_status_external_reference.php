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
        Schema::table('movement', function (Blueprint $table) {
            $table->enum('status', ['completed', 'pending', 'canceled'])->default('pending');
            $table->string('external_reference')->default('NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movement', function (Blueprint $table) {
            //
        });
    }
};
