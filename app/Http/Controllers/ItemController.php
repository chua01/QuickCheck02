<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemSupplier;
use App\Models\Supplier;
use App\Models\Tag;
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

    // public function store(Request $request)
    // {
    //     dd($request);
    //     // Validate the request data
    //     $validatedData = $request->validate([
    //         // 'pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // assuming pic is the name of the file input
    //         'name' => 'required|string|max:255',
    //         'description' => 'required|string|max:255',
    //         'quantity' => 'required|integer',
    //         'unit' => 'required|string|max:255',
    //         'price1' => 'required|numeric',
    //         'price2' => 'required|numeric',
    //         'price3' => 'required|numeric',
    //         'minlevel' => 'required|integer',
    //     ]);

    //     // Handle file upload
    //     if ($request->hasFile('pic')) {
    //         $imagePath = $request->file('pic')->store('public/images'); // You can specify the folder where to store images
    //         $validatedData['pic'] = $imagePath;
    //     }

    //     // Create the item
    //     $item = Item::create($validatedData);

    //     // Optionally, you can redirect the user after successful submission
    //     return redirect()->route('item')->with('success', 'Item added successfully!');
    // }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'pic' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // assuming pic is the name of the file input
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

        // Handle classification results
        if ($request->has('classification_results') && !empty($request->input('classification_results'))) {
            $classificationResults = json_decode($request->input('classification_results'), true);

            foreach ($classificationResults as $result) {
                $tagName = $result['className'];

                // Find or create the tag
                $tag = Tag::firstOrCreate(['name' => $tagName]);

                // Attach the tag to the item using the 'tag_item' pivot table
                $item->tags()->attach($tag->id);
            }
        }

        // Optionally, you can redirect the user after successful submission
        return redirect()->route('item')->with('success', 'Item added successfully!');
    }



    public function edit($id)
    {
        $item = Item::find($id);
        return view('manageitem.edit', compact('item'));
    }

    // public function update(Request $request, $id)
    // {
    //     $item = Item::findOrFail($id);

    //     // Validate the form data
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'nullable|string|max:255',
    //         'quantity' => 'required|integer',
    //         'unit' => 'required|string|max:10',
    //         'price1' => 'required|numeric',
    //         'price2' => 'nullable|numeric',
    //         'price3' => 'nullable|numeric',
    //         'minlevel' => 'nullable|integer',
    //         'pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     // Check if a new file has been uploaded
    //     if ($request->hasFile('pic')) {
    //         // Delete old image if a new one is uploaded
    //         if ($item->pic) {
    //             Storage::delete('public/' . $item->pic);
    //         }

    //         // Store the new image
    //         $imagePath = $request->file('pic')->store('items', 'public');
    //         $item->pic = $imagePath;
    //     } else {
    //         // Retain the old image
    //         $item->pic = $request->input('old_pic');
    //     }

    //     // Update other item details
    //     $item->name = $request->input('name');
    //     $item->description = $request->input('description');
    //     $item->quantity = $request->input('quantity');
    //     $item->unit = $request->input('unit');
    //     $item->price1 = $request->input('price1');
    //     $item->price2 = $request->input('price2');
    //     $item->price3 = $request->input('price3');
    //     $item->minlevel = $request->input('minlevel');

    //     // Save the updated item
    //     $item->save();

    //     // Redirect with a success message
    //     return redirect()->route('item')->with('success', 'Item updated successfully');
    // }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'quantity' => 'required|integer',
            'unit' => 'required|string|max:10',
            'price1' => 'required|numeric',
            'price2' => 'nullable|numeric',
            'price3' => 'nullable|numeric',
            'minlevel' => 'nullable|integer',
            'pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if a new file has been uploaded
        if ($request->hasFile('pic')) {
            // Delete old image if a new one is uploaded
            if ($item->pic) {
                Storage::delete('public/' . $item->pic);
            }

            // Store the new image
            $imagePath = $request->file('pic')->store('items', 'public');
            $item->pic = $imagePath;
        } else {
            // Retain the old image
            $item->pic = $request->input('old_pic');
        }

        // Update other item details
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->quantity = $request->input('quantity');
        $item->unit = $request->input('unit');
        $item->price1 = $request->input('price1');
        $item->price2 = $request->input('price2');
        $item->price3 = $request->input('price3');
        $item->minlevel = $request->input('minlevel');

        // Save the updated item
        $item->save();

        // Handle classification results
        if ($request->has('classification_results') && !empty($request->input('classification_results'))) {
            $classificationResults = json_decode($request->input('classification_results'), true);

            // Detach all existing tags
            $item->tags()->detach();

            foreach ($classificationResults as $result) {
                $tagName = $result['className'];

                // Find or create the tag
                $tag = Tag::firstOrCreate(['name' => $tagName]);

                // Attach the tag to the item
                $item->tags()->attach($tag->id);
            }
        }

        // Redirect with a success message
        return redirect()->route('item')->with('success', 'Item updated successfully');
    }

    public function destroy($id)
    {
        Item::find($id)->delete();
        return redirect()->route('item');
    }
}
