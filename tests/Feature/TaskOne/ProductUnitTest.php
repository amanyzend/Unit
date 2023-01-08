<?php

namespace Tests\Feature\TaskOne;

use Tests\Feature\BaseTest;


class ProductUnitTest extends BaseTest
{
    public function test_adding_product_inventory()
    {
        $this->createProduct(['name' => 'Flour']);
        $this->createUnit([
            'name' => 'Gram',
            'modifier' => 1,
        ]);
        $this->createUnit([
            'name' => 'Kilo Gram',
            'modifier' => 1000,
        ]);
        $productUnit = [
            'product_id' => 1,
            'unit_id' => 1,
            'amount' => 1,
        ];
        $response = $this->post('inventories', $productUnit);
        $this->assertDatabaseHas('product_unit', $productUnit);
        $response->assertStatus(200);
    }

    public function test_inventory_1()
    {
        $this->createProduct(['name' => 'Flour']);
        $this->createUnit([
            'name' => 'Gram',
            'modifier' => 1,
        ]);
        $this->createUnit([
            'name' => 'Centi Gram',
            'modifier' => 1/100,
        ]);
        $this->createUnit([
            'name' => 'Kilo Gram',
            'modifier' => 1000,
        ]);
        $this->post('inventories', ['product_id' => 1, 'unit_id' => 1, 'amount' => 25]);
        $this->post('inventories', ['product_id' => 1, 'unit_id' => 2, 'amount' => 50]);
        $this->post('inventories', ['product_id' => 1, 'unit_id' => 3, 'amount' => 2]);

        $response = $this->get('products/1');
        $response->assertOk();
        $this->assertEquals(25+0.5+2000, $response->json('total_quantity'));

        $this->post('inventories', ['product_id' => 1, 'unit_id' => 1, 'amount' => -50,]);

        $response = $this->get('products/1');
        $response->assertOk();
        $this->assertEquals(25+0.5+2000-50, $response->json('total_quantity'));

        $this->post('inventories', ['product_id' => 1, 'unit_id' => 2, 'amount' => 230]);

        $response = $this->get('products/1');
        $response->assertOk();
        $this->assertEquals(25+0.5+2000-50+2.3, $response->json('total_quantity'));
    }

    public function test_inventory_2()
    {
        $this->createProduct(['name' => 'Flour']);
        $this->createUnit(['name' => 'Gram', 'modifier' => 1]);
        $this->createUnit(['name' => 'Pound', 'modifier' => 453.59237]);
        $this->post('inventories', ['product_id' => 1, 'unit_id' => 1, 'amount' => 50]);
        $this->post('inventories', ['product_id' => 1, 'unit_id' => 2, 'amount' => 1]);
        $response = $this->get('products/1');
        $response->assertOk();
        $this->assertEquals(453.59237 + 50, $response->json('total_quantity'));
    }

    public function test_get_quantity_by_unit()
    {
        $this->createProduct(['name' => 'Flour']);
        $this->createUnit(['name' => 'Gram', 'modifier' => 1]);
        $this->createUnit(['name' => 'Pound', 'modifier' => 453.59237]);
        $this->createUnit(['name' => 'Kilo Gram', 'modifier' => 1000]);
        $this->createUnit(['name' => 'Ton', 'modifier' => 1000000]);
        $this->post('inventories', ['product_id' => 1, 'unit_id' => 1, 'amount' => 50]);
        $this->post('inventories', ['product_id' => 1, 'unit_id' => 2, 'amount' => 1]);
        $response = $this->get('products/1?unit_id=2');
        $response->assertOk();
        $this->assertEquals(1.1102311310924389, $response->json('total_quantity_by_unit_id'));
        $response = $this->get('products/1?unit_id=3');
        $response->assertOk();
        $this->assertEquals(0.50359237, $response->json('total_quantity_by_unit_id'));
        $response = $this->get('products/1?unit_id=1');
        $response->assertOk();
        $this->assertEquals(503.59237, $response->json('total_quantity_by_unit_id'));
    }
}
