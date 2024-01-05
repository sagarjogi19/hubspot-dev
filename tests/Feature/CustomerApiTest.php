<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase;

    // Test case for listing customers
    public function test_can_list_customers()
    {
        // Create some test customers
        $customers = Customer::factory(3)->create();

        // Make a GET request to the customers index endpoint
        $response = $this->get('/api/customers');

        // Assert the response status code
        $response->assertStatus(200);

        // Assert the structure of the response JSON
        $response->assertJsonStructure([
            '*' => ['id', 'firstname', 'lastname', 'email', 'created_at', 'updated_at'],
        ]);

        // Assert that the response contains the test customers
        foreach ($customers as $customer) {
            $response->assertJsonFragment([
                'id' => $customer->id,
                'firstname' => $customer->firstname,
                'lastname' => $customer->lastname,
                'email' => $customer->email,
            ]);
        }
    }

    // Test case for getting a customer by ID
    public function test_can_get_customer_by_id()
    {
        // Create a test customer
        $customer = Customer::factory()->create();

        // Make a GET request to the customer show endpoint
        $response = $this->get("/api/customers/{$customer->id}");

        // Assert the response status code
        $response->assertStatus(200);

        // Assert the structure of the response JSON
        $response->assertJsonStructure(['id', 'firstname', 'lastname', 'email', 'created_at', 'updated_at']);

        // Assert that the response contains the test customer
        $response->assertJson([
            'id' => $customer->id,
            'firstname' => $customer->firstname,
            'lastname' => $customer->lastname,
            'email' => $customer->email,
        ]);
    }

    // Add test cases for creating, updating, and deleting customers
    // ...

    // For example, a test case for creating a customer
    public function test_can_create_customer()
    {
        $customerData = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john@example.com',
        ];

        $response = $this->post('/api/customers', $customerData);

        $response->assertStatus(201);

        $response->assertJsonStructure(['id', 'firstname', 'lastname', 'email', 'created_at', 'updated_at']);

        $response->assertJson([
            'firstname' => $customerData['firstname'],
            'lastname' => $customerData['lastname'],
            'email' => $customerData['email'],
        ]);

        // Optionally, assert that the customer has been stored in the database
        $this->assertDatabaseHas('customers', $customerData);
    }

    // Similarly, add test cases for updating and deleting customers
    // ...

    // For example, a test case for deleting a customer
    public function test_can_delete_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->delete("/api/customers/{$customer->id}");

        $response->assertStatus(204);

        // Optionally, assert that the customer has been deleted from the database
        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}
