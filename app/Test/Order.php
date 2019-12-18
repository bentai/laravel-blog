<?php

namespace App\Test;

use Illuminate\Http\Request;

class Order
{
    //
    protected $products = [];
    protected $total;
    public function add(Product $product)
    {
        $this->products[] = $product;
        $this->total += $product->price();
    }


    public function products()
    {
        return $this->products;
    }

    public function total(){
        return $this->total;
    }
}
