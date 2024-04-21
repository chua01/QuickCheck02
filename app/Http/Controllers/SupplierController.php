<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::with('contact','address')->get(); // Use get() instead of all()
        // You can remove the dd() if you don't need to debug
        // dd($suppliers); 
        return view('managesupplier.manage', compact('suppliers'));
    }
    
    public function create(){
        return view('managesupplier.create');
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
    
        // Create the supplier
        $supplierData = array_merge($validatedData, ['address_id' => $address->id]);
        $supplier = Supplier::create($supplierData);
    
        // Create the contact
        $contactInfo = [
            'contactnumber' => $validatedData['contactno'],
            'person_id' => $supplier->id,
            'type' => 'supplier',
        ];
        $contact = Contact::create($contactInfo);
    
        // Optionally, you can redirect the user after successful submission
        return redirect()->route('supplier')->with('success', 'Item added successfully!');
    }
    
}