<?php

namespace Tests\Feature\Models;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_calculates_subtotal_and_total_correctly()
    {
        $user = User::factory()->create();

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'type' => 'online_sale',
            'shipping_cost' => 5.00,
            'subtotal' => 0,
            'total' => 0,
        ]);

        OrderItem::factory()->create([
            'order_id' => $order->id,
            'unit_price' => 10.00,
            'quantity' => 1.500,
        ]);

        OrderItem::factory()->create([
            'order_id' => $order->id,
            'unit_price' => 5.00,
            'quantity' => 2.000,
        ]);

        $order->recalculateTotals();

        $this->assertEquals(25.00, $order->subtotal);
        $this->assertEquals(30.00, $order->total);
    }
}