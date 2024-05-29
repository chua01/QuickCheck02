@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add Item'])

    <div class="container-fluid py-4">
        <form method="POST" action="{{route('salesorder.updateOrderItem', ['id' => $quotation->id])}}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">New Item</p>
                                <div class="ms-auto">
                                    <a href=""
                                        onclick="return confirm('Do you want to delete item? Item will be deleted permanently')"
                                        class="btn btn-danger btn-sm ms-auto">Delete</a>
                                    <a href="" class="btn btn-info btn-sm ms-auto">Edit</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body border rounded-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p class="mb-0">{{ $quotation->customer->name }}</p>
                                                <p class="mb-0">{{ $quotation->customer->email }}</p>
                                                <p class="mb-4">{{ $quotation->customer->contact->first()->contactnumber }}</p>
                                                <label for="example-text-input" class="form-control-label">Billing Address</label>
                                                <p class="mb-0">{{ $quotation->customer->address->location }}</p>
                                                <p class="mb-0">{{ $quotation->customer->address->code }}</p>
                                                <p class="mb-0">{{ $quotation->customer->address->street }}</p>
                                                <p class="mb-0">{{ $quotation->customer->address->state }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex flex-column justify-content-between">
                                            <div class="d-flex justify-content-end mb-3">
                                                <a href="{{route('salesorder.editOrderInfo1', ['id'=>$quotation->id])}}" class="btn btn-info">Edit</a>
                                            </div>
                                            @if($quotation->deliveryaddress !== null)
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Delivery Address</label>
                                                <p class="mb-0">{{ $quotation->deliveryaddress->location }}</p>
                                                <p class="mb-0">{{ $quotation->deliveryaddress->code }}</p>
                                                <p class="mb-0">{{ $quotation->deliveryaddress->street }}</p>
                                                <p class="mb-0">{{ $quotation->deliveryaddress->state }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <p>Items</p>
                                {{-- list of order item --}}
                                <div class="table-responsive p-0">
                                    <div id="dropdownLists"></div>
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Items</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Unit Price (RM)</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantities</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($quotation->customeritem as $orderitem)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <select name="orderitem[{{$orderitem->id}}][id]" class="form-control">
                                                                    <option value="{{$orderitem->item->id}}">{{$orderitem->item->name}} ( {{$orderitem->item->unit}} )</option>
                                                                    @foreach($items as $item)
                                                                        <option value="{{$item->id}}">{{$item->name}} ( {{$item->unit}} )</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control no-border-bottom" placeholder="0.00"
                                                            value="{{$orderitem->amount}}" name="orderitem[{{$orderitem->id}}][price]">
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <input type="number" class="form-control no-border-bottom" style="text-align: right;"
                                                                    value="{{$orderitem->quantity}}" name="orderitem[{{$orderitem->id}}][quantity]" placeholder="0">
                                                            </div>
                                                            <div class="col-4">
                                                                <p class="text-sm mb-0 h6">{{$orderitem->item->unit}}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <p class="text-sm font-weight-bold mb-0">RM {{$orderitem->quantity * $orderitem->amount}}</p>
                                                    </td>
                                                    <td class="align-middle text-end">
                                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                            <a href="{{route('salesorder.deleteOrderItem', ['id' => $orderitem->id])}}" class="text-sm font-weight-bold mb-0 ps-2">Delete</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </form>
                                            <form method="POST" action="{{ route('salesorder.addItem', ['id' => $quotation->id]) }}" enctype="multipart/form-data">
                                                @csrf
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <select name="orderitem" class="form-control">
                                                                    <option value="">no item selected</option>
                                                                    @foreach($items as $item)
                                                                        <option value="{{$item->id}}">{{$item->name}} ( {{$item->unit}} )</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control no-border-bottom" placeholder="0.00" value="0.00" name="price">
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <input type="number" class="form-control no-border-bottom" style="text-align: right;" value="0" name="quantity" placeholder="0">
                                                            </div>
                                                            <div class="col-4">
                                                                <p class="text-sm mb-0 h6"></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <p class="text-sm font-weight-bold mb-0"></p>
                                                    </td>
                                                    <td class="align-middle text-end">
                                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                            <button type="submit" class="btn btn-success">Add</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </form>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card">
                                    <div class="row card-body border rounded-3">
                                        <div class="col-4">
                                            <table class="table table-borderless mb-0">
                                                <tbody class="text-start">
                                                    <tr>
                                                        <td class="text-start"><label for="extra_fee" class="form-control-label">Items Total (RM):</label></td>
                                                        <td class="text-start">{{ number_format($quotation->amount / 1.06 + $quotation->discount - $quotation->extra_fee , 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-start"><label for="extra_fee" class="form-control-label">Extra Fee (RM):</label></td>
                                                        <td class="text-start">{{ number_format($quotation->extra_fee, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-start"><label for="extra_fee" class="form-control-label">Total before discount (RM):</label></td>
                                                        <td class="text-start">{{ number_format($quotation->amount / 1.06 + $quotation->discount , 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-start"><label for="discount" class="form-control-label">Discount (RM):</label></td>
                                                        <td class="text-start">- {{ number_format($quotation->discount, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-start"><label for="tax" class="form-control-label">Tax (RM):</label></td>
                                                        <td class="text-start">{{ number_format($quotation->amount / 1.06, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-start"><label for="amount" class="form-control-label">Amount Charged (RM):</label></td>
                                                        <td class="text-start">{{ number_format($quotation->amount,2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-8 text-end">
                                            <a href="{{route('salesorder.editOrderInfo2', ['id' => $quotation->id])}}" class="btn btn-info">Edit</a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
        </form>
        @include('layouts.footers.auth.footer')
    </div>
    <style>
        .file-upload-container {
            position: relative;
            display: inline-block;
        }

        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-image {
            width: 100%;
            height: auto;
            border: 2px dashed #ccc;
            padding: 10px;
            box-sizing: border-box;
            display: block;
            border-radius: 10px;
            aspect-ratio: 1/1;
            object-fit: cover;
        }

        .file-upload-image:hover {
            opacity: 0.7;
        }
    </style>

@endsection
