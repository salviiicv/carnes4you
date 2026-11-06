<?php

namespace App\Livewire\Tpv;

use App\Models\Product;
use Livewire\Component;

class Terminal extends Component
{
    public function render()
    {
        $products = Product::all();    

        return view('livewire.tpv.terminal', [
            'products' => $products
        ]);;
    }
}