<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_products()
    {
        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
    }

    public function test_can_create_product()
    {
        $productData = [
            'name' => 'Sample Product',
            'description' => 'Product Description',
            'price' => 19.99,
        ];

        $response = $this->post(route('products.store'), $productData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('products', $productData);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create();

        $updatedData = [
            'name' => 'Updated Product',
            'description' => 'Updated Description',
            'price' => 29.99,
        ];

        $response = $this->put(route('products.update', $product->id), $updatedData);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', $updatedData);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('products.destroy', $product->id));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
