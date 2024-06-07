<!DOCTYPE html>
<html>
<head>
    <title>Delivery Order</title>
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
        .details, .items {
            width: 100%;
            margin: 10px 0;
            border-collapse: collapse;
            font-size: 12px;
        }
        .details th, .details td, .items th, .items td {
            border: 1px solid #ddd;
            padding: 5px;
        }
        .details th, .items th {
            background-color: #f9f9f9;
        }
        .details table, .items table{
            width: 100%;
        };
        .items th {
            text-align: left;
        }
        .items td {
            text-align: right;
        }
        .items td.item-name {
            text-align: left;
        }
        .company-info, .client-info {
            font-size: 10px;
            width: 45%;
            display: inline-block;
            vertical-align: top;
        }
        .client-info {
            text-align: right;
        }
        .section-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>DELIVERY ORDER</h1>
        </div>
        <div class="company-info">
            <h2 class="section-title">C K S Trading</h2>
            <p>Your Business Address</p>
            <p>City</p>
            <p>Country</p>
            <p>Postal</p>
        </div>
        <div class="client-info">
            <h2 class="section-title">DELIVER TO:</h2>
            <p>{{ $quotation->customer->name }}</p>
            <p>{{ $quotation->deliveryaddress->location }}</p>
            <p>{{ $quotation->deliveryaddress->code }}</p>
            <p>{{ $quotation->deliveryaddress->street }}</p>
            <p>{{ $quotation->deliveryaddress->state }}</p>
        </div>
        <div class="details">
            <table>
                <tr>
                    <th>DELIVERY NO #</th>
                    <th>DATE</th>
                </tr>
                <tr>
                    <td>{{ $quotation->id }}</td>
                    <td>{{ $quotation->date }}</td>
                </tr>
            </table>
        </div>
        <div class="items">
            <h2 class="section-title">ITEMS</h2>
            <table>
                <tr>
                    <th>ITEMS</th>
                    <th>QUANTITY</th>
                </tr>
                @foreach($quotation->customeritem as $item)
                    <tr>
                        <td class="item-name">{{ $item->item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
