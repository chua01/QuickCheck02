<?php

namespace App\Http\Controllers;

use App\Models\Item;
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
        return view('manageitem.create');
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


    public function show()
    {
        $item = Item::whereNotNull('pic')->first();
        // dd(Storage::url($item->pic));

        return view('manageitem.showpic', compact('item'));
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
