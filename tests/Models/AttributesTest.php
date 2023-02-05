<?php

namespace Tests\Models;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\Attributes;

class AttributesTest extends \Tests\TestCase
{
    use DatabaseTransactions;

    public function setUp():void
    {
        parent::setUp();

        app('db')->delete("DELETE FROM attributes");
    }

    /**
     * Test that you can create an Attribute.
     *
     * @return void
     */
    public function test_that_you_can_create_attribute()
    {
        $attribute = [
            'sku' => 'test',
            'name' => 'foo',
            'value' => 'bar'
        ];
        Attributes::create($attribute);

        $result = app('db')->select("SELECT COUNT(*) AS count
                                    FROM attributes
                                    WHERE sku = '".$attribute['sku']."'
                                    AND name = '".$attribute['name']."'
                                    AND value = '".$attribute['value']."'");
        $this->assertEquals($result[0]->count, 1);
    }

    /**
     * Test that you can't create a duplicate Attribute with an existing sku/name combo.
     *
     * @return void
     */
    public function test_that_you_cant_create_attribute_with_duplicate_sku_and_name()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        $attribute = [
            'sku' => 'test',
            'name' => 'foo',
            'value' => 'bar'
        ];
        Attributes::create($attribute);
        Attributes::create($attribute);
    }

    /**
     * Test that you can create an Attribute with a duplicate sku
     *
     * @return void
     */
    public function test_that_you_can_create_attribute_with_duplicate_sku()
    {
        $sku = 'dup';
        $attribute1 = [
            'sku' => $sku,
            'name' => 'foo',
            'value' => 'bar'
        ];
        $attribute2 = [
            'sku' => $sku,
            'name' => 'bar',
            'value' => 'foo'
        ];

        Attributes::create($attribute1);
        Attributes::create($attribute2);

        $result = app('db')->select("SELECT COUNT(*) AS count FROM attributes WHERE sku = '$sku'");
        $this->assertEquals($result[0]->count, 2);
    }

    /**
     * Test that you can create an Attribute with a duplicate name
     *
     * @return void
     */
    public function test_that_you_can_create_attribute_with_duplicate_name()
    {
        $name = 'dup';
        $attribute1 = [
            'sku' => 'sku1',
            'name' => $name,
            'value' => 'bar'
        ];
        $attribute2 = [
            'sku' => 'sku2',
            'name' => $name,
            'value' => 'foo'
        ];

        Attributes::create($attribute1);
        Attributes::create($attribute2);

        $result = app('db')->select("SELECT COUNT(*) AS count FROM attributes WHERE name = '$name'");
        $this->assertEquals($result[0]->count, 2);
    }
}
