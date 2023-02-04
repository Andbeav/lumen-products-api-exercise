<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp():void
    {
        parent::setUp();

        app('db')->table('product')->insert(
            [
                'sku' => 'xyz'
            ]
        );

        foreach ([
            'color' => 'blue',
            'shape' => 'square',
            'amount' => '300'
        ] as $key => $value) {
            app('db')->table('attributes')->insert([
                'sku' => 'xyz',
                'name' => $key,
                'value' => $value
            ]);
        }
    }

    /**
     * Test that ProductController@index returns a product.
     *
     * @return void
     */
    public function test_that_index_returns_products()
    {
        $this->json('GET', '/products')->seeJson([
            [
                "sku" => "xyz",
                "attributes" => [
                    "color" => "blue",
                    "shape" => "square",
                    "amount" => "300"
                ]
            ]
        ]);
    }

    /**
     * Test that ProductController@insert inserts
     * the relevant Product and Attributes records.
     *
     * @return void
     */
    public function test_that_insert_inserts_products_and_attributes()
    {
        $mock_sku = '123';
        $mock_product = [
            'sku' => $mock_sku,
            'attributes' => [
                'language' => 'en',
                'pages' => '500',
                'year' => '2000'
            ]
        ];

        $this->json('POST', '/products', [$mock_product])->seeJson([
            'created' => [$mock_sku],
            'failed' => []
        ]);

        $product_results = app('db')->select("SELECT COUNT(*) AS count FROM product WHERE sku = '$mock_sku'");

        $this->assertEquals($product_results[0]->count, 1);

        foreach ($mock_product['attributes'] as $name => $value) {
            $attributes_results = app('db')->select('SELECT COUNT(*) AS count '.
                                                    'FROM attributes '.
                                                    "WHERE sku = '$mock_sku' ".
                                                    "AND name = '$name' ".
                                                    "AND value = '$value'"
            );
            $this->assertEquals($attributes_results[0]->count, 1);
        }
    }

    /**
     * Test that ProductController@insert fails
     * to insert when the given product exists.
     *
     * @return void
     */
    public function test_that_insert_fails_to_insert_existing_product()
    {
        $existing_product = [
            "sku" => "xyz",
            "attributes" => [
                "color" => "blue",
                "shape" => "square",
                "amount" => "300"
            ]
        ];

        $this->json('POST', '/products', [$existing_product]);
        $response = json_decode($this->response->getContent(), true);

        $this->assertMatchesRegularExpression("/Duplicate entry 'xyz'.*product_sku_unique/", $response['failed']['xyz']);
    }
}
