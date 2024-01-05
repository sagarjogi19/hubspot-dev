<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketApiTest extends TestCase
{
    use RefreshDatabase;

    // Test case for listing tickets
    public function test_can_list_tickets()
    {
        // Create some test tickets
        $tickets = Ticket::factory(3)->create();

        // Make a GET request to the tickets index endpoint
        $response = $this->get('/api/tickets');

        // Assert the response status code
        $response->assertStatus(200);

        // Assert the structure of the response JSON
        $response->assertJsonStructure([
            '*' => ['id', 'subject', 'content', 'hs_pipeline', 'hs_pipeline_stage', 'created_at', 'updated_at'],
        ]);

        // Assert that the response contains the test tickets
        foreach ($tickets as $ticket) {
            $response->assertJsonFragment([
                'id' => $ticket->id,
                'subject' => $ticket->subject,
                'content' => $ticket->content,
                'hs_pipeline' => $ticket->hs_pipeline,
                'hs_pipeline_stage' => $ticket->hs_pipeline_stage,
            ]);
        }
    }

    // Test case for getting a ticket by ID
    public function test_can_get_ticket_by_id()
    {
        // Create a test ticket
        $ticket = Ticket::factory()->create();

        // Make a GET request to the ticket show endpoint
        $response = $this->get("/api/tickets/{$ticket->id}");

        // Assert the response status code
        $response->assertStatus(200);

        // Assert the structure of the response JSON
        $response->assertJsonStructure(['id', 'subject', 'content', 'hs_pipeline', 'hs_pipeline_stage', 'created_at', 'updated_at']);

        // Assert that the response contains the test ticket
        $response->assertJson([
            'id' => $ticket->id,
            'subject' => $ticket->subject,
            'content' => $ticket->content,
            'hs_pipeline' => $ticket->hs_pipeline,
            'hs_pipeline_stage' => $ticket->hs_pipeline_stage,
        ]);
    }

    // Add test cases for creating, updating, and deleting tickets
    // ...

    // For example, a test case for creating a ticket
    public function test_can_create_ticket()
    {
        $ticketData = [
            'subject' => 'Support Ticket',
            'content' => 'Issue description',
            'hs_pipeline' => 123,
            'hs_pipeline_stage' => 456,
        ];

        $response = $this->post('/api/tickets', $ticketData);

        $response->assertStatus(201);

        $response->assertJsonStructure(['id', 'subject', 'content', 'hs_pipeline', 'hs_pipeline_stage', 'created_at', 'updated_at']);

        $response->assertJson([
            'subject' => $ticketData['subject'],
            'content' => $ticketData['content'],
            'hs_pipeline' => $ticketData['hs_pipeline'],
            'hs_pipeline_stage' => $ticketData['hs_pipeline_stage'],
        ]);

        // Optionally, assert that the ticket has been stored in the database
        $this->assertDatabaseHas('tickets', $ticketData);
    }

    // Similarly, add test cases for updating and deleting tickets
    // ...

    // For example, a test case for deleting a ticket
    public function test_can_delete_ticket()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->delete("/api/tickets/{$ticket->id}");

        $response->assertStatus(204);

        // Optionally, assert that the ticket has been deleted from the database
        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }
}
