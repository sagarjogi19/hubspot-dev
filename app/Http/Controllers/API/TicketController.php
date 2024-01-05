<?php

namespace App\Http\Controllers\API;

use App\Services\HubSpotService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    protected $hubSpotService;

    public function __construct(HubSpotService $hubSpotService)
    {
        $this->hubSpotService = $hubSpotService;
    }

    public function index()
    {
        $tickets = $this->hubSpotService->getTickets();
        return response()->json($tickets);
    }

    public function show($ticketId)
    {
        $ticket = $this->hubSpotService->getTicketById($ticketId);
        return response()->json($ticket);
    }

    public function store(Request $request)
    {
        $ticketData = $request->validate([
            'subject' => 'required|string',
            'content' => 'required|string',
            'hs_pipeline' => 'integer',
            'hs_pipeline_stage' => 'integer',
            // Add other validation rules as needed
        ]);

        $newTicket = $this->hubSpotService->createTicket($ticketData);
        return response()->json($newTicket, 201);
    }

    public function update(Request $request, $ticketId)
    {
        $ticketData = $request->validate([
            'subject' => 'string',
            'content' => 'string',
            'hs_pipeline' => 'integer',
            'hs_pipeline_stage' => 'integer',
            // Add other validation rules as needed
        ]);

        $updatedTicket = $this->hubSpotService->updateTicket($ticketId, $ticketData);
        return response()->json($updatedTicket);
    }

    public function destroy($ticketId)
    {
        $this->hubSpotService->deleteTicket($ticketId);
        return response()->json(null, 204);
    }
}
