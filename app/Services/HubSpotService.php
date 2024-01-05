<?php

namespace App\Services;

use Eolica\LaravelHubspot\Facades\Hubspot;
use SevenShores\Hubspot\Factory;

class HubSpotService
{
    protected $hubspot;

    public function __construct()
    {
        $this->hubspot = Hubspot::connection('main');
    }

    public function getProducts()
    {
        return $this->hubspot->products()->all();
    }

    public function getProductById($productId)
    {
        return $this->hubspot->products()->getById($productId);
    }

    public function createProduct($productData)
    {
        return $this->hubspot->products()->create($productData);
    }

    public function updateProduct($productId, $productData)
    {
        return $this->hubspot->products()->update($productId, $productData);
    }

    public function deleteProduct($productId)
    {
        return $this->hubspot->products()->delete($productId);
    }

    public function getContacts()
    {
        return $this->hubspot->contacts()->all();
    }

    public function getContactById($customerId)
    {
        return $this->hubspot->contacts()->getById($customerId);
    }

    public function createContact($customerData)
    {
        return $this->hubspot->contacts()->create($customerData);
    }

    public function updateContact($customerId, $customerData)
    {
        return $this->hubspot->contacts()->update($customerId, $customerData);
    }

    public function deleteContact($customerId)
    {
        return $this->hubspot->contacts()->delete($customerId);
    }

    public function getTickets()
    {
        return $this->hubspot->tickets()->all();
    }

    public function getTicketById($ticketId)
    {
        return $this->hubspot->tickets()->getById($ticketId);
    }

    public function createTicket($ticketData)
    {
        return $this->hubspot->tickets()->create($ticketData);
    }

    public function updateTicket($ticketId, $ticketData)
    {
        return $this->hubspot->tickets()->update($ticketId, $ticketData);
    }

    public function deleteTicket($ticketId)
    {
        return $this->hubspot->tickets()->delete($ticketId);
    }
}
