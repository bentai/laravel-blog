<?php

namespace Tests\Unit;

use App\Test\Product;
use App\Test\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{

    public function test_an_order_consists_of_products()
    {
        $order = $this->createOrderWithProducts();

        $this->assertEquals(2, count($order->products()));
    }

    public function test_an_order_can_determine_the_total_cost_of_all_its_products()
    {
        $order = $this->createOrderWithProducts();

        $this->assertEquals(66, $order->total());
    }

    public function createOrderWithProducts()
    {
        $order = new Order();

        $product = new Product('Fallout 4', 59);
        $product2 = new Product('Pillowcase', 7);

        $order->add($product);
        $order->add($product2);

        return $order;
    }
}
