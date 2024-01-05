<?php

namespace App\Http\Controllers\API;

use App\Services\HubSpotService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    protected $hubSpotService;

    public function __construct(HubSpotService $hubSpotService)
    {
        $this->hubSpotService = $hubSpotService;
    }

    public function index()
    {
        $customers = $this->hubSpotService->getContacts();
        return response()->json($customers);
    }

    public function show($customerId)
    {
        $customer = $this->hubSpotService->getContactById($customerId);
        return response()->json($customer);
    }

    public function store(Request $request)
    {
        $customerData = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            // Add other validation rules as needed
        ]);

        $newCustomer = $this->hubSpotService->createContact($customerData);
        return response()->json($newCustomer, 201);
    }

    public function update(Request $request, $customerId)
    {
        $customerData = $request->validate([
            'firstname' => 'string',
            'lastname' => 'string',
            'email' => 'email',
            // Add other validation rules as needed
        ]);

        $updatedCustomer = $this->hubSpotService->updateContact($customerId, $customerData);
        return response()->json($updatedCustomer);
    }

    public function destroy($customerId)
    {
        $this->hubSpotService->deleteContact($customerId);
        return response()->json(null, 204);
    }
}
