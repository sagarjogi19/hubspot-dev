<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_customers()
    {
        $response = $this->get(route('customers.index'));
        $response->assertStatus(200);
    }

    public function test_can_create_customer()
    {
        $customerData = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john@example.com',
        ];

        $response = $this->post(route('customers.store'), $customerData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('customers', $customerData);
    }

    public function test_can_update_customer()
    {
        $customer = Customer::factory()->create();

        $updatedData = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'jane@example.com',
        ];

        $response = $this->put(route('customers.update', $customer->id), $updatedData);
        $response->assertStatus(200);

        $this->assertDatabaseHas('customers', $updatedData);
    }

    public function test_can_delete_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->delete(route('customers.destroy', $customer->id));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}