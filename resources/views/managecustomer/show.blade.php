@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add Supplier'])
  
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="text-uppercase mb-0">customer information</p>
                            <button class="btn btn-primary btn-sm ms-auto" type="submit">Submit</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-sm">Customer Information</p>
                        <div class="card border">
                            <div class="row card-body">
                                <div class="col-8">
                                    <label class="mb-0" for="supplier info">Customer Information</label>
                                    <p class="mb-0">{{$customer->name}}</p>
                                    <p class="mb-0">{{$customer->email}}</p>
                                    <p class="mb-4">{{$customer->contact->first()->contactnumber}}</p>
                                    <label class="mb-0" for="address">Billing Address</label>
                                    <p class="mb-0">{{$customer->address->location}}</p>
                                    <p class="mb-0">{{$customer->address->code}}</p>
                                    <p class="mb-0">{{$customer->address->street}}</p>
                                    <p class="mb-0">{{$customer->address->state}}</p>

                                </div>
                                <div class="col-4">
                                    <div class="card mb-4" href="{{route('supplier.itemList', ['id' => $customer->id])}}">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="numbers">
                                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Amount Spend</p>
                                                        <h5 class="font-weight-bolder">
                                                           RM {{number_format($totalAmountBought,2)}}
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="numbers">
                                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Customer Order</p>
                                                        <h5 class="font-weight-bolder">
                                                            {{$totalCustomerOrder}}
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <p class="text-sm">Customer Order</p>
                        {{-- <label for="">Purchase Order</label> --}}
                        @foreach($customer->customerorder as $order)
                        <a class="card border mb-2" href="{{route('customer.showOrder', ['id' => $order->id])}}">
                            <div class="row card-body">
                                <div class="col-2">{{$order->id}}</div>
                                <div class="col-4">{{$order->updated_at}}</div>
                                <div class="col-4">RM {{number_format($order->amount,2)}}</div>
                                <div class="col-2">completed</div>
                                {{-- <div class="col-4">{{$order->id}}</div> --}}
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('supplier.update', ['id' => $customer->id]) }}">
            @csrf

        </form>
        @include('layouts.footers.auth.footer')
    </div>

    <script>
        // Display alert if any validation errors occur
        @if ($errors->any())
            alert('{{$errors->first()}}');
        @endif
    </script>
@endsection
