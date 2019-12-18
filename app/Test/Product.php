<?php

namespace App\Test;

use Illuminate\Http\Request;

class Product
{
    public $name;
    public $price;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
    public function name()
    {
        return $this->name;
    }

    public function price()
    {
        return $this->price;
    }
}
