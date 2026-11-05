<?php

namespace Tests\Feature\Models;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockMovementTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_product_stock_on_movement_creation()
    {
        $product = Product::factory()->create(['stock' => 0]);

        StockMovement::factory()->create([
            'product_id' => $product->id,
            'movement_type' => 'in',
            'quantity' => 15.500,
        ]);

        $product->refresh();
        $this->assertEquals(15.500, $product->stock);

        StockMovement::factory()->create([
            'product_id' => $product->id,
            'movement_type' => 'out',
            'quantity' => 2.250,
        ]);

        $product->refresh();
        $this->assertEquals(13.250, $product->stock);
    }
}