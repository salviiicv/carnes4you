<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('address_line');
            $table->string('country')->default('España');
            $table->string('state')->nullable();
            $table->string('province')->nullable();
            $table->string('city');
            $table->string('zip');
            $table->string('street_number')->nullable();
            $table->string('floor')->nullable();
            $table->string('door')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};

#test