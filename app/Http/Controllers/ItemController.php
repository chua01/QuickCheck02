<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemSupplier;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    //
    public function index()
    {
        $items = Item::all();
        return view('manageitem.manage', compact('items'));
    }
    
    public function create()
    {
        $suppliers = Supplier::all();
        return view('manageitem.create', compact('suppliers'));
    }
   
    // public function store(Request $request)
    // {
    //     $attributes = request()->validate([
    //         'name' => 'required|max:255|min:2',
    //         'description' => 'required',
    //         'quantity' => 'required',
    //     ]);
    //     Item::create($attributes);

    //     return view('manageitem.manage');
    // }


    public function show($id)
    {
        $item = Item::find($id);
        // dd(Storage::url($item->pic));
        $itemSuppliers = ItemSupplier::where('item_id', $item->id)->get();
        $suppliers = Supplier::all();

        $itemSupplierIds = $itemSuppliers->pluck('supplier_id')->toArray();

        // Filter out suppliers that are in the itemSuppliers list
        $suppliers = $suppliers->reject(function ($supplier) use ($itemSupplierIds) {
            return in_array($supplier->id, $itemSupplierIds);
        });

        return view('manageitem.shows', compact('item', 'suppliers', 'itemSuppliers'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            // 'pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // assuming pic is the name of the file input
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'unit' => 'required|string|max:255',
            'price1' => 'required|numeric',
            'price2' => 'required|numeric',
            'price3' => 'required|numeric',
            'minlevel' => 'required|integer',
        ]);

        // Handle file upload
        if ($request->hasFile('pic')) {
            $imagePath = $request->file('pic')->store('public/images'); // You can specify the folder where to store images
            $validatedData['pic'] = $imagePath;
        }

        // Create the item
        $item = Item::create($validatedData);

        // Optionally, you can redirect the user after successful submission
        return redirect()->route('item')->with('success', 'Item added successfully!');
    }
}
