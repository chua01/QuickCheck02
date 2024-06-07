<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\CustomerOrderItem;
use App\Models\Item;
use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesOrderController extends Controller
{
    public function index()
    {
        $quotations = Quotation::with('customer.contact')->get();
        return view('managesalesorder.manage', compact('quotations'));
    }

    public function create(Request $request)
    {
        $customers = Customer::with('address', 'contact')->get();
        $items = Item::all();
        return view('managesalesorder.create', compact('items', 'customers'));
    }

    public function imagelabel()
    {
        return view('managesalesorder.imagelabel');
    }

    public function show($id)
    {
        $items = Item::all();
        $quotation = Quotation::find($id);
        return view('managesalesorder.show', compact('quotation', 'items'));
    }

    public function addItem(Request $request, $id)
    {
        if ($request->orderitem !== null) {
            CustomerOrderItem::create([
                'quotation_id' => $id,
                'item_id' => $request->orderitem,
                'amount' => $request->price,
                'quantity' => $request->quantity,
            ]);

            $quotation = Quotation::find($id);
            $amount = $this->calculateTotal($quotation->customeritem, $quotation->extra_fee, $quotation->discount);
            $quotation->update(['amount' => $amount]);
        }

        return redirect()->route('salesorder.show', $id);
    }

    public function updateOrderItem(Request $request, $id)
    {
        $quotation = Quotation::find($id);
        foreach ($quotation->customeritem as $item) {
            $item->update([
                'item_id' => $request->orderitem[$item->id]['id'],
                'amount' => $request->orderitem[$item->id]['price'],
                'quantity' => $request->orderitem[$item->id]['quantity'],
            ]);
        }

        $amount = $this->calculateTotal($quotation->customeritem, $quotation->extra_fee, $quotation->discount);
        $quotation->update(['amount' => $amount]);

        return redirect()->route('salesorder.show', $id);
    }

    public function showForm()
    {
        return view('managesalesorder.show');
    }

    public function store(Request $request)
    {
        $total = 0;
        foreach ($request->orderitem as $item) {
            if ($item['id'] !== null) {
                $total += $item['price'] * $item['quantity'];
            }
        }

        $finalAmount = ($total - $request->discount + $request->extrafee) * 1.06;

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

            $address = Address::create($validatedData);

            $customerData = array_merge($validatedData, ['address_id' => $address->id]);
            $customer = Customer::create($customerData);

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

        foreach ($request->orderitem as $item) {
            if ($item['id'] !== null) {
                CustomerOrderItem::create([
                    'quotation_id' => $quotation->id,
                    'item_id' => $item['id'],
                    'amount' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
            }
        }

        return redirect()->route('salesorder');
    }

    public function calculateTotal($items, $extra, $discount)
    {
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item->amount * $item->quantity;
        }

        return ($totalAmount - $discount + $extra) * 1.06;
    }

    public function editOrderInfo1($id)
    {
        $quotation = Quotation::find($id);
        $customers = Customer::with('address', 'contact')->get();
        return view('managesalesorder.editOrderInfo1', compact('quotation', 'customers'));
    }

    public function editOrderInfo2($id)
    {
        $quotation = Quotation::find($id);
        $itemstotal = 0;
        foreach ($quotation->customeritem as $item) {
            $itemstotal += $item->amount * $item->quantity;
        }
        return view('managesalesorder.editOrderInfo2', compact('quotation', 'itemstotal'));
    }

    public function updateOrderInfo1(Request $request, $id)
    {
        $quotation = Quotation::find($id);

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

            $address = Address::create($validatedData);

            $customerData = array_merge($validatedData, ['address_id' => $address->id]);
            $customer = Customer::create($customerData);

            $contactInfo = [
                'contactnumber' => $validatedData['contactno'],
                'person_id' => $customer->id,
                'type' => 'customer',
            ];
            Contact::create($contactInfo);
            $customer_id = $customer->id;
        }

        $quotation->update(['customer_id' => $customer_id]);

        if ($request->input('checkboxName') === '1') {
            if ($request->delivery_address === null) {
                $delivery_address = Address::create();
                $quotation->update([
                    'delivery_address' => $delivery_address->id,
                    'delivery' => 'yes',
                ]);
            }
            $quotation->deliveryaddress->update([
                'location' => $request->delivery_location,
                'code' => $request->delivery_code,
                'state' => $request->delivery_state,
                'street' => $request->delivery_street,
            ]);
        } else {
            if ($quotation->delivery_address !== null) {
                $quotation->deliveryaddress->delete();
                $quotation->update(['delivery' => 'no']);
            }
        }

        return redirect()->route('salesorder.show', $id);
    }

    public function updateOrderInfo2(Request $request, $id)
    {
        $quotation = Quotation::find($id);
        $quotation->update([
            'extra_fee' => $request->extrafee,
            'discount' => $request->discount,
        ]);

        $amount = $this->calculateTotal($quotation->customeritem, $quotation->extra_fee, $quotation->discount);
        $quotation->update(['amount' => $amount]);

        return redirect()->route('salesorder.show', $id);
    }

    public function deleteOrderItem($id)
    {
        $item = CustomerOrderItem::find($id);
        $quotation = Quotation::find($item->quotation_id);
        $item->delete();

        $amount = $this->calculateTotal($quotation->customeritem, $quotation->extra_fee, $quotation->discount);
        $quotation->update(['amount' => $amount]);

        return redirect()->route('salesorder.show', $item->quotation_id);
    }

    public function print($type, $id)
    {
        $quotation = Quotation::findOrFail($id);
        $items = Item::all();
        
        $view = '';

        switch ($type) {
            case 'quotation':
                $view = 'managesalesorder.print_quotation';
                break;
            case 'invoice':
                $view = 'managesalesorder.print_invoice';
                break;
            case 'delivery_order':
                $view = 'managesalesorder.print_delivery_order';
                break;
            case 'sales_order':
                $view = 'managesalesorder.print_sales_order';
                break;
            default:
                abort(404);
        }

        $pdf = PDF::loadView($view, compact('quotation', 'items'));
        return $pdf->stream($type . '.pdf');
    }
}
