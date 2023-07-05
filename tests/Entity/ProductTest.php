<?php
namespace App\tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;

class ProductTest extends TestCase
{
    public function testDefault()
    {
        $product = new Product('Pomme', 'food', 1);
                                 $this->assertSame(0.055, $product->computeTVA());
    }
}
