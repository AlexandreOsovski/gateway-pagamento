<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Rfc4122\UuidV8;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default(UuidV8::uuid4());
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('document_type', ['RG', 'CPF', 'CNH', 'NULL'])->default('NULL');
            $table->string('document_number')->nullable();
            $table->string('password');
            $table->string('status')->default('active');
            $table->string('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
};