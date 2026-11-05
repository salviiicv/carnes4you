<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tpv_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamp('opened_at');
            $table->timestamp('closed_at')->nullable();

            $table->decimal('starting_cash', 10, 2)->default(0.00);
            $table->decimal('closing_cash', 10, 2)->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tpv_sessions');
    }
};