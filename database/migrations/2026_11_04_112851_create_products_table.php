<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->text('description')->nullable();
            
            $table->decimal('cost_price', 10, 2)->default(0.00);
            $table->decimal('price', 10, 2);
            
            $table->decimal('stock', 10, 3)->default(0.000);
            $table->decimal('min_quantity', 10, 3)->default(0.250);
            $table->decimal('step_quantity', 10, 3)->default(0.250);

            $table->string('unit_type')->default('kg');
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};