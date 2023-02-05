<?php

namespace Tests\Models;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\Product;

class ProductTest extends \Tests\TestCase
{
    use DatabaseTransactions;

    public function setUp():void
    {
        parent::setUp();

        app('db')->delete("DELETE FROM product");
    }

    /**
     * Test that you can create a Product.
     *
     * @return void
     */
    public function test_that_you_can_create_product()
    {
        $sku = 'test';
        Product::create(['sku' => $sku]);

        $result = app('db')->select("SELECT COUNT(*) AS count FROM product WHERE sku = '$sku'");
        $this->assertEquals($result[0]->count, 1);
    }

    /**
     * Test that you can't create a duplicate Product.
     *
     * @return void
     */
    public function test_that_you_cant_create_duplicate_product()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        $sku = 'dup';
        Product::create(['sku' => $sku]);
        Product::create(['sku' => $sku]);
    }
}
