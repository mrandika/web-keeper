<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TransactionCartTest extends TestCase
{
    public $cart = [], $total = 0;
    public $item = ['id' => 1, 'price' => 1000, 'stock' => 10];

    public function add_to_cart()
    {
        $this->cart[] = ['item' => $this->item, 'qty' => 1];
        $this->total = $this->item['price'];
    }

    public function test_can_add_to_cart()
    {
        $this->add_to_cart();

        $column = array_column($this->cart, 'item');
        $this->assertTrue(in_array($this->item, $column));
    }

    public function test_can_increment_if_item_already_exist()
    {
        $this->add_to_cart();

        $column = array_column($this->cart, 'item');

        if (in_array($this->item, $column)) {
            $this->cart[0]['qty'] += 1;
            $this->total += $this->item['price'];
        }

        $this->assertTrue($this->cart[0]['qty'] == 2);
        $this->assertTrue($this->total == 2000);
    }

    public function test_can_decrement_the_item()
    {
        $this->add_to_cart();

        $column = array_column($this->cart, 'item');

        if (in_array($this->item, $column)) {
            $this->cart[0]['qty'] -= 1;
            $this->total -= $this->item['price'];
        }

        $this->assertTrue($this->cart[0]['qty'] == 0);
        $this->assertTrue($this->total == 0);
    }
}
