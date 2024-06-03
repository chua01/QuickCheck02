<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    //
    public function index()
    {
        $purchaseorders = PurchaseOrder::all();
        return view('managepurchaseorder.manage', compact('purchaseorders'));
    }
    
    public function create()
    {
        // $purchaseorders = PurchaseOrder::all();
        $suppliers = Supplier::with('address', 'contact', 'supply.item')->get();
        // dd($suppliers);
        $items = Item:: all();
        return view('managepurchaseorder.create', compact('suppliers', 'items'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $total = 0;
        foreach ($request->orderitem as $item) {
            if($item['id']!==null){

                $total = $total + $item['price'] * $item['quantity'];
            }
        }
        $finalAmount = ($total - $request->discount + $request->extrafee) * 1.06;
        // $finalAmount = $this->calculateTotal($request->orderitem, $request->extrafee, $request->discont);
        $supplier_id = $request->supplier;
    
        $purchaseorder = PurchaseOrder::create([
            'supplier_id' => $supplier_id,
            'amount' => $finalAmount,
            'date' => Carbon::now()->toDateString(),
            'discount' => $request->discount,
            'tax' => $request->tax,
            'extra_fee' => $request->extrafee,]);

        foreach ($request->orderitem as $item) {
            if($item['id']!==null){

                PurchaseOrderItem::create([
                    'purchaseorder_id' => $purchaseorder->id,
                    'item_id' => $item['id'],
                    'amount' => $item['price'],
                    'quantity' => $item['quantity'],
    
                ]);
            }
        }

        return redirect()->route('purchaseorder');
    }

    public function show($id)
    {
        $items = Item::all();
        $purchaseorder = PurchaseOrder::find($id);
        return view('managepurchaseorder.show', compact('purchaseorder', 'items'));
    }

    public function editOrderInfo1($id)
    {
        $purchaseorder = PurchaseOrder::find($id);
        // dd($purchaseorder->deliveryaddress);
        $suppliers = Supplier::with('address', 'contact')->get();
        return view('managepurchaseorder.editOrderInfo1', compact('purchaseorder', 'suppliers'));
    }
   
    public function editOrderInfo2($id)
    {
        $purchaseorder = PurchaseOrder::find($id);
        $itemstotal = 0;
        foreach($purchaseorder->orderitems as $item){
            $itemstotal += $item->amount * $item->quantity;
        }
        return view('managepurchaseorder.editOrderInfo2', compact('purchaseorder', 'itemstotal'));
    }

    public function updateOrderInfo1(Request $request, $id)
    {
        // dd($request);
        $purchaseorder = PurchaseOrder::find($id);
        $supplier_id = $request->supplier;
        $purchaseorder->update([
            'supplier_id' => $supplier_id,
        ]);
        return redirect()->route('purchaseorder.show', $id);
    }

    public function updateOrderInfo2(Request $request, $id){
        $purchaseorder = PurchaseOrder::find($id);
        $purchaseorder->update([
            'extra_fee'=>$request->extrafee,
            'discount'=>$request->discount,
        ]);
        $amount = $this->calculateTotal($purchaseorder->orderitems, $purchaseorder->extra_fee, $purchaseorder->discount);
        $purchaseorder->update([
            'amount' => $amount,
        ]);
        return redirect()->route('purchaseorder.show', $id);
    }

    public function deleteOrderItem($id){
        $item = PurchaseOrderItem::find($id);
        $purchaseorder = PurchaseOrder::find($item->purchaseorder_id);
        $item->delete();
        $amount = $this->calculateTotal($purchaseorder->orderitems, $purchaseorder->extra_fee, $purchaseorder->discount);
        $purchaseorder->update([
            'amount' => $amount,
        ]);
        return redirect()->route('purchaseorder.show',['id' => $purchaseorder->id]);
    }

    public function addItem(Request $request, $id)
    {
        if($request->orderitem!==null){

            PurchaseOrderItem::create([
                'purchaseorder_id' => $id,
                'item_id' => $request->orderitem,
                'amount' => $request->price,
                'quantity' => $request->quantity,
    
            ]);
            // $orderitems = PurchaseOrderItem::where('purchaseorder_id',$id)->get();
            $purchaseorder = PurchaseOrder::find($id);
            // dd($purchaseorder->orderitems);
            $amount = $this->calculateTotal($purchaseorder->orderitems, $purchaseorder->extra_fee, $purchaseorder->discount);
            $purchaseorder->update([
                'amount' => $amount,
            ]);
        }
        return redirect()->route('purchaseorder.show', $id);
    }

    public function updateOrderItem(Request $request, $id)
    {
        $purchaseorder = PurchaseOrder::find($id);
        foreach ($purchaseorder->orderitems as $item) {
            $item->update([
                'item_id' => $request->orderitem[$item->id]['id'],
                'amount' => $request->orderitem[$item->id]['price'],
                'quantity' => $request->orderitem[$item->id]['quantity'],
            ]);
        }
        $amount = $this->calculateTotal($purchaseorder->orderitems, $purchaseorder->extra_fee, $purchaseorder->discount);
        $purchaseorder->update([
            'amount' => $amount,
        ]);
        return redirect()->route('purchaseorder.show', $id);
    }

    public function calculateTotal($items, $extra, $discount)
    {
        $totalAmount = 0;
        foreach ($items as $item) {
            // dd($item);
            $totalAmount = $totalAmount + $item->amount * $item->quantity;
        }
        $totalAmount = ($totalAmount - $discount + $extra) * 1.06;
        return $totalAmount;
    }
}