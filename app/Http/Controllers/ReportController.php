<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\PurchaseOrder;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    private function summarizeOrdersByStatus($orders)
    {
        return $orders->groupBy('status')->map(function ($statusGroup, $status) {
            return [
                'status' => $status,
                'count' => $statusGroup->count()
            ];
        })->values();
    }

    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        // Fetch data for customer orders, purchase orders, and customer expenses
        $customerOrders = Quotation::whereBetween('date', [$start_date, $end_date])->get();
        $purchaseOrders = PurchaseOrder::whereBetween('date', [$start_date, $end_date])->get();

        // Summarize data
        $customerOrderSummaryByStatus = $this->summarizeOrdersByStatus($customerOrders);
        $purchaseOrderSummary = $this->summarizePurchaseOrders($purchaseOrders);
        $customerOrderSummary = $this->summarizeCustomerOrders($customerOrders);
        $customerExpenses = $this->summarizeCustomerExpenses($customerOrders);

        // Format data for the chart
        $chartData = [
            'labels' => $customerOrderSummaryByStatus->pluck('status')->toArray(),
            'data' => $customerOrderSummaryByStatus->pluck('count')->toArray()
        ];

        return view('reports.generate', compact('customerOrderSummary', 'purchaseOrderSummary', 'customerExpenses', 'start_date', 'end_date', 'chartData'));
    }

    private function summarizeCustomerOrders($orders)
    {
        return $orders->groupBy(function ($order) {
            return Carbon::parse($order->updated_at)->format('Y-m');
        })->map(function ($group) {
            return $group->sum('amount');
        })->sortKeys(); // Sort by date (Y-m)
    }

    private function summarizePurchaseOrders($orders)
    {
        return $orders->groupBy(function ($order) {
            return Carbon::parse($order->updated_at)->format('Y-m');
        })->map(function ($group) {
            return $group->sum('amount');
        })->sortKeys(); // Sort by date (Y-m)
    }

    private function summarizeCustomerExpenses($orders)
    {
        return $orders->groupBy('customer_id')->map(function ($group) {
            return $group->sum('amount');
        });
    }

    public function showPolarAreaChart()
    {
        $labels = ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'];
        $data = [11, 16, 7, 3, 14, 5];

        return ['labels' => $labels, 'data' => $data];
    }
}
