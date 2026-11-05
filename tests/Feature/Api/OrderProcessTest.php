<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderProcessTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_processes_an_order_and_updates_stock()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'stock' => 10.000,
            'price' => 12.50,
        ]);

        $payload = [
            'user_id' => $user->id,
            'type' => 'online_sale',
            'payment_method' => 'card',
            'shipping_cost' => 4.50,
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2.000,
                    'unit_price' => 12.50,
                    'product_name' => $product->name ?? 'Carne de prueba',
                ],
            ],
        ];

        $response = $this->postJson('/api/orders', $payload);

        $response->assertStatus(201)->assertJsonStructure([
            'message',
            'order' => [
                'id',
                'order_number',
                'subtotal',
                'total',
                'items',
            ]
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'subtotal' => 25.00,
            'total' => 29.50,
        ]);

        $product->refresh();
        $this->assertEquals(8.000, $product->stock);
    }
}