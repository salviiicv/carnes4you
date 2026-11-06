<?php

namespace App\Livewire\Tpv;

use App\Models\Product;
use Livewire\Component;

class Terminal extends Component
{
    public $cart = [];

    public function addToCart($productId)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $product = Product::find($productId);
            if ($product) {
                $this->cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                ];
            }
        }
    }

    public function increaseQuantity($productId)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        }
    }

    public function decreaseQuantity($productId)
    {
        if (isset($this->cart[$productId])) {
            if ($this->cart[$productId]['quantity'] > 1) {
                $this->cart[$productId]['quantity']--;
            } else {
                unset($this->cart[$productId]);
            }
        }
    }

    public function removeItem($productId)
    {
        unset($this->cart[$productId]);
    }

    public function cancelTicket()
    {
        $this->cart = [];
    }

    public function render()
    {
        $products = Product::all();

        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('livewire.tpv.terminal', [
            'products' => $products,
            'total' => $total,
        ]);
    }
}