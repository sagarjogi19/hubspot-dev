<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::latest()->get();

        return view('ticket.index', [
            'tickets' => $tickets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|max:255',
            'content' => 'required'
        ]);
        
        $ticket = Ticket::create($request->all());

        Alert::success('Success', 'Ticket has been saved !');
        return redirect('/tickets');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);

        return view('ticket.edit', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'subject' => 'required|max:255',
            'content' => 'required'
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update($validated);

        Alert::info('Success', 'Ticket has been updated !');
        return redirect('/tickets');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $deletedTicket = Ticket::findOrFail($id);

            $deletedTicket->delete();

            Alert::error('Success', 'Ticket has been deleted !');
            return redirect('/tickets');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Ticket already used !');
            return redirect('/tickets');
        }
    }
}
