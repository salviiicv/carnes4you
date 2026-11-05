<?php

namespace Tests\Feature\Models;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PreparationType;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_calculates_the_exact_subtotal_based_on_quantity_and_price()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['price' => 10.50]);
        $prepType = PreparationType::factory()->create();

        $item = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'preparation_type_id' => $prepType->id,
            'unit_price' => 10.50,
            'quantity' => 1.250,
        ]);

        $this->assertEquals(13.13, $item->subtotal);
    }
}