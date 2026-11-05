<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tpv_session_id' => 'nullable|exists:tpv_sessions,id',
            'type' => 'required|in:tpv_sale,online_sale',
            'payment_method' => 'required|string',
            'shipping_cost' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.preparation_type_id' => 'nullable|exists:preparation_types,id',
            'items.*.quantity' => 'required|numeric|min:0.001',
            'items.*.unit_price' => 'required|numeric|min=0',
            'items.*.product_name' => 'required|string',
        ]);

        return DB::transaction(function () use ($validated) {
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'tpv_session_id' => $validated['tpv_session_id'] ?? null,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'type' => $validated['type'],
                'status' => 'completed',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'paid',
                'shipping_cost' => $validated['shipping_cost'] ?? 0,
                'subtotal' => 0,
                'total' => 0,
            ]);

            foreach ($validated['items'] as $itemData) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $itemData['product_id'],
                    'preparation_type_id' => $itemData['preparation_type_id'] ?? null,
                    'product_name' => $itemData['product_name'],
                    'unit_price' => $itemData['unit_price'],
                    'quantity' => $itemData['quantity'],
                ]);

                StockMovement::create([
                    'product_id' => $itemData['product_id'],
                    'movement_type' => 'out',
                    'quantity' => $itemData['quantity'],
                    'reason' => 'Venta - Pedido ' . $order->order_number,
                ]);
            }

            $order->recalculateTotals();

            return response()->json([
                'message' => 'Pedido registrado y stock actualizado con éxito.',
                'order' => $order->load('items')
            ], 201);
        });
    }
}