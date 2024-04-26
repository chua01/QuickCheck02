<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrderItem;
use App\Models\Item;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class SalesOrderController extends Controller
{
    //
    public function index()
    {
        return view('managesalesorder.manage');
    }


    public function create()
    {
        $order = SalesOrder::latest()->first();
        if($order==null)
        {
            $order= SalesOrder::create();
            $order->status = '21';
            $order->save();
            dd('create order');
        }
        if($order->status=='21'){
            $order = SalesOrder::with('items.item')->find($order->id);
            // dd("hello", $order->toArray());
            // dd($order);
            $items = Item::all(); // Fetch items from your database, adjust accordingly
            // return view('your-view', compact('items'));
            return  view('managesalesorder.create', compact('order','items'));
        }
        else{
            $order = SalesOrder::create();
            $order->status = '21';
            $order->save();
            $order = SalesOrder::with('items')->find($order->id);
            dd($order);
            return view('managesalesorder.create',compact('order'));
        }
    }

    public function addItem($id)
    {
        CustomerOrderItem::create(['quotation_id'=>$id]);
        // dd('heheh');
        // $items = CustomerOrderItem::where('quotation_id','id')->get();
        // SalesOrder::find($id);

       return redirect(route('salesorder.create'));
    }
}
