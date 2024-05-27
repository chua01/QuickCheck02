<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\CustomerOrderItem;
use App\Models\Item;
use App\Models\Quotation;
use App\Models\SalesOrder;
use Carbon\Carbon;
use Google\Cloud\Vision\Connection\Rest;
use Illuminate\Http\Request;

class SalesOrderController extends Controller
{
    //
    public function index()
    {
        $quotations = Quotation::with('customer.contact')->get();

        // dd($quotations);
        return view('managesalesorder.manage', compact('quotations'));
    }


    public function create(Request $request)
    {
        $customers = Customer::with('address','contact')->get();
        $items = Item::all(); // Fetch items from your database, adjust accordingly
        // return view('your-view', compact('items'));
        // dd($customers);
        return  view('managesalesorder.kalvin', compact('items', 'customers'));
        // return view('managesalesorder.kalvin', compact('order'));
    }

    public function addItem($id)
    {
        CustomerOrderItem::create(['quotation_id' => $id]);
        // dd('heheh');
        // $items = CustomerOrderItem::where('quotation_id','id')->get();
        // SalesOrder::find($id);

        return redirect(route('salesorder.create'));
    }

    public function imagelabel()
    {
        return view('managesalesorder.imagelabel');
    }

    public function showForm()
    {
        return view('managesalesorder.show');
    }
    
    
    public function trysee2(Request $request){
        dd($request);
    }
    
    public function store(Request $request){
        $total = 0;
        foreach($request->orderitem as $item){
            $total = $total + $item['price'] * $item['quantity'];
        }
        $finalAmount = ($total - $request->discount + $request->extrafee)*1.06;
        // dd($request);
        if ($request->input('existingCustomer') === '1') {
            $customer_id = $request->customer;
        } else {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'contactno' => 'required',
                'email' => 'required|email',
                'location' => 'required|string|max:255',
                'street' => 'required|string',
                'state' => 'required|string',
                'code' => 'required|string',
            ]);
        
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
            Contact::create($contactInfo);
            $customer_id = $customer->id;
        }

        if ($request->input('checkboxName') === '1') {
            $delivery_address = Address::create([
                'location' => $request->delivery_location,
                'code' => $request->delivery_code,
                'state' => $request->delivery_state,
                'street' => $request->delivery_street,
            ]);
            
            $quotation = Quotation::create([
                'customer_id' => $customer_id,
                'date' => Carbon::now()->toDateString(),
                'discount' => $request->discount,
                'tax' => $request->tax,
                'extra_fee' => $request->extrafee,
                'delivery_address' => $delivery_address->id,
                'amount' => $finalAmount,
            ]);

        } else {
            $quotation = Quotation::create([
                'customer_id' => $customer_id,
                'amount' => $finalAmount,
                'date' => Carbon::now()->toDateString(),
                'discount' => $request->discount,
                'tax' => $request->tax,
                'extra_fee' => $request->extrafee,
            ]);
        }
        foreach($request->orderitem as $item){
            CustomerOrderItem::create([
                'quotation_id' => $quotation->id,
                'item_id' => $item['id'],
                'amount' => $item['price'],
                'quantity' => $item['quantity'],

            ]);
        }

        return redirect()->route('salesorder');
    }
}
