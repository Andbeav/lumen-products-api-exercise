<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ([
            'size' => 'small',
            'grams' => '100',
            'foo' => 'bar'
        ] as $key => $value) {
            app('db')->table('attributes')->insert([
                'sku' => 'abc',
                'name' => $key,
                'value' => $value
            ]);
        }
    }
}
