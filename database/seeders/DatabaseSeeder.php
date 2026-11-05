<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\CashMovement;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PreparationType;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\TpvSession;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@carnes4you.com'],
            [
                'name' => 'Admin',
                'surname' => 'Carnes4You',
                'email' => 'admin@carnes4you.com',
                'pin_code' => '1234',
                'password' => 'testtest',
            ]
        );

        $empleado = User::firstOrCreate(
            ['email' => 'empleado@carnes4you.com'],
            [
            'name' => 'Empleado',
            'surname' => 'TPV',
            'email' => 'empleado@carnes4you.com',
            'pin_code' => '5678',
            'password' => 'testtest',
            ]
        );

        if (User::where('role', 'cliente')->count() === 0) {
            $clientes = User::factory()->count(10)->create(['role' => 'cliente']);
            foreach ($clientes as $cliente) {
                Address::factory()->count(rand(1, 2))->create([
                    'user_id' => $cliente->id,
                ]);
            }

            $suppliers = Supplier::factory()->count(5)->create();

            $prepTypes = collect(['Fileteado', 'En tacos', 'Picada', 'Pieza entera', 'En brochetas'])->map(fn (string $name) => PreparationType::factory()->create(['name' =>  $name]));

            $products = Product::factory()->count(20)->create([
                'supplier_id' => fn () => $suppliers->random()->id,
            ]);

            foreach ($products as $product) {
                ProductImage::factory()->count(rand(1, 3))->create([
                    'product_id' => $product->id,
                ]);

                StockMovement::factory()->create([
                    'product_id' => $product->id,
                    'movement_type' => 'in',
                    'quantity' => $product->stock,
                    'reason' => 'Carga de stock inicial',
                ]);
            }

            $closedSession = TpvSession::factory()->closed()->create([
                'user_id' => $empleado->id,
            ]);

            CashMovement::factory()->count(3)->create([
                'tpv_session_id' => $closedSession->id,
                'user_id' => $empleado->id,
            ]);

            $activeSession = TpvSession::factory()->create([
                'user_id' => $empleado->id,
                'opened_at' => now(),
                'starting_cash' => 150.00,
            ]);

            $orders = Order::factory()->count(15)->create();

            foreach ($orders as $order) {
                $cliente = $clientes->random();
                $order->user_id = $cliente->id;

                if ($order->type === 'tpv_sale') {
                    $order->tpv_session_id = $activeSession->id;
                    $order->shipping_address_id = null;
                } else {
                    $order->tpv_session_id = null;
                    $order->shipping_address_id = $cliente->addresses->first()?->id;
                }

                $order->save();

                $selectedProducts = $products->random(rand(1, 4));
                $calculatedSubTotal = 0;

                foreach ($selectedProducts as $product) {
                    $item = OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'preparation_type_id' => $prepTypes->random()->id,
                        'product_name' => $product->name,
                        'unit_price' => $product->price,
                    ]);

                    $calculatedSubTotal += $item->subtotal;
                }

                $order->subtotal = $calculatedSubTotal;
                $order->total = $calculatedSubTotal + $order->shipping_cost;
                $order->save();
            }
        }    
    }
}