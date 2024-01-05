<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    // Test case for listing products
    public function test_can_list_products()
    {
        // Create some test products
        $products = Product::factory(3)->create();

        // Make a GET request to the products index endpoint
        $response = $this->get('/api/products');

        // Assert the response status code
        $response->assertStatus(200);

        // Assert the structure of the response JSON
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'description', 'price', 'created_at', 'updated_at'],
        ]);

        // Assert that the response contains the test products
        foreach ($products as $product) {
            $response->assertJsonFragment([
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
            ]);
        }
    }

    // Test case for getting a product by ID
    public function test_can_get_product_by_id()
    {
        // Create a test product
        $product = Product::factory()->create();

        // Make a GET request to the product show endpoint
        $response = $this->get("/api/products/{$product->id}");

        // Assert the response status code
        $response->assertStatus(200);

        // Assert the structure of the response JSON
        $response->assertJsonStructure(['id', 'name', 'description', 'price', 'created_at', 'updated_at']);

        // Assert that the response contains the test product
        $response->assertJson([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
        ]);
    }

    // Add test cases for creating, updating, and deleting products
    // ...

    // For example, a test case for creating a product
    public function test_can_create_product()
    {
        $productData = [
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 19.99,
        ];

        $response = $this->post('/api/products', $productData);

        $response->assertStatus(201);

        $response->assertJsonStructure(['id', 'name', 'description', 'price', 'created_at', 'updated_at']);

        $response->assertJson([
            'name' => $productData['name'],
            'description' => $productData['description'],
            'price' => $productData['price'],
        ]);

        // Optionally, assert that the product has been stored in the database
        $this->assertDatabaseHas('products', $productData);
    }

    // Similarly, add test cases for updating and deleting products
    // ...

    // For example, a test case for deleting a product
    public function test_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete("/api/products/{$product->id}");

        $response->assertStatus(204);

        // Optionally, assert that the product has been deleted from the database
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
