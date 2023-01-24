<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Product;
use App\Models\Attributes;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Returns a list of products presented as a JSON encoded string.
     *
     * @return string A JSON encoded string
     */
    public function index()
    {
        $response = [];

        $products = Product::get();
        foreach ($products as $product) {
            $sku = $product['sku'];
            $item = [
                'sku' => $sku,
                'attributes' => []
            ];

            $attributes = Attributes::where('sku', '=', $sku)->get();
            foreach ($attributes as $attribute) {
                $item['attributes'][$attribute['name']] = $attribute['value'];
            }

            $response[] = $item;
        }

        return response()->json($response);
    }

    /**
     * Inserts a product as well as its attributes, and return 'created': true/false
     *
     * @return string A JSON encoded string
     */
    public function insert(Request $request)
    {
        $response = [
            'created' => [],
            'failed' => []
        ];

        $products = $request->input();

        foreach($products as $product) {
            $sku = $product['sku'];
            try {
                Product::create(['sku' => $sku]);

                foreach ($product['attributes'] as $name => $value) {
                    Attributes::create([
                        'sku' => $sku,
                        'name' => $name,
                        'value' => $value
                    ]);
                }

                $response['created'][] = $sku;
            } catch (\PDOException $e) {
                $response['failed'][$sku] = $e->getMessage();
            }
        }
        return response()->json($response);
    }
}
