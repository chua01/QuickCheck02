<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\CustomerOrderItem;
use App\Models\Item;
use App\Models\ItemFlow;
use App\Models\ItemSupplier;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Quotation;
use App\Models\Supplier;
use App\Models\Tag;
use App\Models\TagItem;
use App\Models\User;

class ReportController extends Controller
{
    //
    public function report()
    {
        $customerOrders = Quotation::with('customer')->get();
        $purchaseOrders = PurchaseOrder::with('supplier')->get();
        $customers = Customer::all();
        $suppliers = Supplier::all();

        // Prepare data for charts
        $customerOrderData = $this->prepareOrderData($customerOrders);
        $purchaseOrderData = $this->prepareOrderData($purchaseOrders);

        return view('report', compact('customerOrderData', 'purchaseOrderData', 'customers', 'suppliers'));
   
    }

    private function prepareOrderData($orders)
    {
        $data = [
            'labels' => [],
            'amounts' => []
        ];

        foreach ($orders as $order) {
            $data['labels'][] = $order->date;
            $data['amounts'][] = $order->amount;
        }

        return $data;
    }
}
