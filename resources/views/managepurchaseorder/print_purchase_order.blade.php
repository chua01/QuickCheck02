<!DOCTYPE html>
<html>
<head>
    <title>Purchase Order</title>
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
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1, h2, h3, p {
            margin: 0;
            padding: 5px 0;
        }
        h1 {
            text-align: center;
            margin-bottom: 10px;
        }
        .header, .footer {
            text-align: center;
        }
        .details, .items, .summary-table {
            width: 100%;
            margin: 10px 0;
            border-collapse: collapse;
            font-size: 12px;
        }
        .details th, .details td, .items th, .items td, .summary-table th, .summary-table td {
            border: 1px solid #ddd;
            padding: 5px;
        }
        .details th, .items th, .summary-table th {
            background-color: #f9f9f9;
        }
        .details table, .items table {
            width: 100%;
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
        .company-info, .supplier-info {
            font-size: 10px;
            width: 45%;
            display: inline-block;
            vertical-align: top;
        }
        .supplier-info {
            text-align: right;
        }
        .summary {
            margin: 10px 0;
            text-align: right;
        }
        .summary p {
            margin: 5px 0;
        }
        .section-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
        }
        .summary-table-container {
            text-align: right;
            width: 100%;
        }
        .summary-table {
            width: 40%;
            margin-left: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PURCHASE ORDER</h1>
        </div>
        <div class="company-info">
            <h2 class="section-title">C K S Trading</h2>
            <p>Your Business Address</p>
            <p>City</p>
            <p>Country</p>
            <p>Postal</p>
        </div>
        <div class="supplier-info">
            <h2 class="section-title">SUPPLIER:</h2>
            <p>{{ $purchaseOrder->supplier->name }}</p>
            <p>{{ $purchaseOrder->supplier->address->location }}</p>
            <p>{{ $purchaseOrder->supplier->address->code }}</p>
            <p>{{ $purchaseOrder->supplier->address->street }}</p>
            <p>{{ $purchaseOrder->supplier->address->state }}</p>
        </div>
        <div class="details">
            <table>
                <tr>
                    <th>PURCHASE ORDER NO #</th>
                    <th>DATE</th>
                    <th>AMOUNT DUE</th>
                </tr>
                <tr>
                    <td>{{ $purchaseOrder->id }}</td>
                    <td>{{ $purchaseOrder->date }}</td>
                    <td>RM {{ number_format($purchaseOrder->amount, 2) }}</td>
                </tr>
            </table>
        </div>
        <div class="items">
            <h2 class="section-title">ITEMS</h2>
            <table>
                <tr>
                    <th>ITEMS</th>
                    <th>DESCRIPTION</th>
                    <th>QUANTITY</th>
                    <th>PRICE</th>
                    <th>AMOUNT</th>
                </tr>
                @foreach($purchaseOrder->orderItems as $item)
                    <tr>
                        <td class="item-name">{{ $item->item->name }}</td>
                        <td>{{ $item->item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->amount, 2) }}</td>
                        <td>{{ number_format($item->quantity * $item->amount, 2) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="summary-table-container">
            <table class="summary-table">
                <tr>
                    <th>SUB-TOTAL</th>
                    <td>RM {{ number_format($purchaseOrder->amount / 1.06 + $purchaseOrder->discount - $purchaseOrder->extra_fee, 2) }}</td>
                </tr>
                <tr>
                    <th>TAX RATE</th>
                    <td>6%</td>
                </tr>
                <tr>
                    <th>TAX</th>
                    <td>RM {{ number_format($purchaseOrder->amount / 1.06 * 0.06, 2) }}</td>
                </tr>
                <tr>
                    <th>TOTAL</th>
                    <td>RM {{ number_format($purchaseOrder->amount, 2) }}</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
