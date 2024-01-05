<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::latest()->get();

        return view('customer.index', [
            'customers' => $customers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'email' => 'required|max:50|email|unique:customers'
        ]);
        
        $customer = Customer::create($request->except(['_token']));

        Alert::success('Success', 'Customer has been saved !');
        return redirect('/customers');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        return view('customer.edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'email' => 'required|max:50|email|unique:customers,email,' . $id . ',id',
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50'
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($validated);

        Alert::info('Success', 'Customer has been updated !');
        return redirect('/customers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $deletedCustomer = Customer::findOrFail($id);

            $deletedCustomer->delete();

            Alert::error('Success', 'Customer has been deleted !');
            return redirect('/customers');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Customer already used !');
            return redirect('/customers');
        }
    }
}
