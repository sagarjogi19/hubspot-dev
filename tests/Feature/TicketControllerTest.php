<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_tickets()
    {
        $response = $this->get(route('tickets.index'));
        $response->assertStatus(200);
    }

    public function test_can_create_ticket()
    {
        $customer = Ticket::factory()->create();

        $ticketData = [
            'subject' => 'Support Ticket',
            'content' => 'Issue description'
        ];

        $response = $this->post(route('tickets.store'), $ticketData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('tickets', $ticketData);
    }

    public function test_can_update_ticket()
    {
        $ticket = Ticket::factory()->create();

        $updatedData = [
            'subject' => 'Support Ticket',
            'content' => 'Issue description'
        ];

        $response = $this->put(route('tickets.update', $ticket->id), $updatedData);
        $response->assertStatus(200);

        $this->assertDatabaseHas('tickets', $updatedData);
    }

    public function test_can_delete_ticket()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->delete(route('tickets.destroy', $ticket->id));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }
}
