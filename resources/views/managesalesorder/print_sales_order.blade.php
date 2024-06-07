<!DOCTYPE html>
<html>
<head>
    <title>Sales Order</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1, h2, h3, p {
            margin: 0;
            padding: 5px 0;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .header, .footer {
            text-align: center;
        }
        .details, .items {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .details th, .details td, .items th, .items td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        .details th, .items th {
            background-color: #f9f9f9;
        }
        .items th {
            text-align: left;
        }
        .items td {
            text-align: right;
        }
        .items td.item-name {
            text-align: left;
        }
        .totals {
            margin: 20px 0;
            text-align: right;
        }
        .totals p {
            margin: 5px 0;
        }
        .customer-info, .your-info {
            font-size: 12px;
            width: 45%;
            display: inline-block;
            vertical-align: top;
        }
        .your-info {
            margin-right: 5%;
        }
        .totals {
            text-align: left;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sales Order</h1>
            <p>C K S Trading</p>
        </div>
        <div class="your-info">
            <h2 class="section-title">Supplier Information</h2>
            <p>Name: C K S Trading</p>
            <p>Email: info@ckstrading.com</p>
            <p>Contact: +123456789</p>
            <p>Address: 123 Street Name, City, State, ZIP</p>
            <p>Order Date: {{ $quotation->date }}</p>
        </div>
        <div class="customer-info">
            <h2 class="section-title">Customer Information</h2>
            <p>Name: {{ $quotation->customer->name }}</p>
            <p>Email: {{ $quotation->customer->email }}</p>
            <p>Contact: {{ $quotation->customer->contact->first()->contactnumber }}</p>
            <p>Billing Address:</p>
            <p>{{ $quotation->customer->address->location }}</p>
            <p>{{ $quotation->customer->address->code }}</p>
            <p>{{ $quotation->customer->address->street }}</p>
            <p>{{ $quotation->customer->address->state }}</p>
        </div>
        @if($quotation->deliveryaddress)
        <div class="customer-info">
            <h2 class="section-title">Delivery Address</h2>
            <p>{{ $quotation->deliveryaddress->location }}</p>
            <p>{{ $quotation->deliveryaddress->code }}</p>
            <p>{{ $quotation->deliveryaddress->street }}</p>
            <p>{{ $quotation->deliveryaddress->state }}</p>
        </div>
        @endif
        <h2 class="section-title">Items</h2>
        <table class="items">
            <thead>
                <tr>
                    <th class="item-name">Item Name</th>
                    <th>Unit Price (RM)</th>
                    <th>Quantity</th>
                    <th>Total (RM)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation->customeritem as $item)
                    <tr>
                        <td class="item-name">{{ $item->item->name }}</td>
                        <td>{{ number_format($item->amount, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->quantity * $item->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="totals">
            <h2 class="section-title">Summary</h2>
            <p>Items Total (RM): {{ number_format($quotation->amount / 1.06 + $quotation->discount - $quotation->extra_fee, 2) }}</p>
            <p>Extra Fee (RM): {{ number_format($quotation->extra_fee, 2) }}</p>
            <p>Total before discount (RM): {{ number_format($quotation->amount / 1.06 + $quotation->discount, 2) }}</p>
            <p>Discount (RM): -{{ number_format($quotation->discount, 2) }}</p>
            <p>Tax (RM): {{ number_format($quotation->amount / 1.06 * 0.06, 2) }}</p>
            <h3>Amount Charged (RM): {{ number_format($quotation->amount, 2) }}</h3>
        </div>
        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
