<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Quotation;
use Google\Cloud\Vision\Connection\Rest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $customers = Customer::with('contact', 'address')->get(); // Use get() instead of all()
        // You can remove the dd() if you don't need to debug
        // dd($customers); 
        return view('managecustomer.manage', compact('customers'));
    }

    public function create()
    {
        return view('managecustomer.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contactno' => 'required',
            'email' => 'required|email',
            'location' => 'required|string|max:255',
            'street' => 'required|string',
            'state' => 'required|string',
            'code' => 'required|string',
        ]);

        // Handle file upload
        if ($request->hasFile('pic')) {
            $imagePath = $request->file('pic')->store('public/images'); // You can specify the folder where to store images
            $validatedData['pic'] = $imagePath;
        }

        // Create the address
        $address = Address::create($validatedData);

        // Create the customer
        $customerData = array_merge($validatedData, ['address_id' => $address->id]);
        $customer = Customer::create($customerData);

        // Create the contact
        $contactInfo = [
            'contactnumber' => $validatedData['contactno'],
            'person_id' => $customer->id,
            'type' => 'customer',
        ];
        $contact = Contact::create($contactInfo);

        // Optionally, you can redirect the user after successful submission
        return redirect()->route('customer')->with('success', 'Item added successfully!');
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('managecustomer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        $customer->contact->first()->update([
            'contactnumber' => $request->contactno,
        ]);
        $customer->address->update([
            'location' => $request->location,
            'code' => $request->code,
            'street' => $request->street,
            'state' => $request->state,
        ]);
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return redirect()->route('customer');
    }

    public function show($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            abort(404, 'Customer not found');
        }

        $totalAmountBought = $customer->customerorder->sum('amount');
        $totalCustomerOrder = $customer->customerorder->count();

        return view('managecustomer.show', compact('customer', 'totalAmountBought', 'totalCustomerOrder'));
    }

    public function showOrder($id)
    {
        $items = Item::all();
        $quotation = Quotation::find($id);
        return view('managecustomer.showOrder', compact('quotation', 'items'));
    }
}
