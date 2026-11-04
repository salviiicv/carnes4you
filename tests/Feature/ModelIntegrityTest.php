<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelIntegrityTest extends TestCase
{
    use RefreshDatabase; // Limpia la BD de test en cada ejecución

    public function test_models_can_be_instantiated_and_related()
    {
        // Crear un usuario
        $user = User::create([
            'name' => 'Salvador',
            'email' => 'salva@carnes4you.test',
            'role' => 'cliente'
        ]);

        $this->assertDatabaseHas('users', ['email' => 'salva@carnes4you.test']);

        // Comprobar relación con pedidos
        $order = $user->orders()->create([
            'order_number' => 'ORD-001',
            'payment_method' => 'card',
            'subtotal' => 10.00,
            'total' => 10.00
        ]);

        $this->assertEquals(1, $user->orders->count());
        $this->assertEquals($user->id, $order->user->id);
    }
}