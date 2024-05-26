<?php

namespace App\Http\Controllers;

use App\Models\ItemSupplier;
use Illuminate\Http\Request;

class ItemSupplierController extends Controller
{
    //
    public function store(Request $request, $id){
        ItemSupplier::create([
            'item_id' => $id,
            'supplier_id' => $request->supplier,
        ]);

        return redirect()->route('item.show', ['id' => $id]);
    }
    
    public function destroy($id){
        $itemSupplier = ItemSupplier::find($id);
        $item_id = $itemSupplier->item_id;
        $itemSupplier->delete();
        return redirect()->route('item.show', ['id' => $item_id]);
    }
}
