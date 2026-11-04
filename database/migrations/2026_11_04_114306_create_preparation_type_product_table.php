<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preparation_type_product', function (Blueprint $table) {
            $table->foreignId('preparation_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->primary(['preparation_type_id', 'product_id']);
        });
    }
    public function down():void
    {
        Schema::dropIfExists('preparation_type_product');
    }
};