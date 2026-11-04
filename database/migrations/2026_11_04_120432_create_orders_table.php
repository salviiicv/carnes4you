<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('tpv_session_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('shipping_address_id')->nullable()->constrained('addresses')->onDelete('set null');

            $table->string('order_number')->unique();
            $table->string('type')->default('online_delivery');
            $table->string('status')->default('pending');

            $table->string('payment_method');
            $table->string('payment_status')->default('pending');

            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2);

            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};