@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add Supplier'])
  
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="text-uppercase mb-0">supplier information</p>
                            <button class="btn btn-primary btn-sm ms-auto" type="submit">Submit</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-sm">Supplier Information</p>
                        <div class="card border">
                            <div class="row card-body">
                                <div class="col-8">
                                    <label class="mb-0" for="supplier info">Supplier Information</label>
                                    <p class="mb-0">{{$supplier->name}}</p>
                                    <p class="mb-0">{{$supplier->email}}</p>
                                    <p class="mb-4">{{$supplier->contact->first()->contactnumber}}</p>
                                    <label class="mb-0" for="address">Billing Address</label>
                                    <p class="mb-0">{{$supplier->address->location}}</p>
                                    <p class="mb-0">{{$supplier->address->code}}</p>
                                    <p class="mb-0">{{$supplier->address->street}}</p>
                                    <p class="mb-0">{{$supplier->address->state}}</p>

                                </div>
                                <div class="col-4">
                                    <a class="card mb-4" href="{{route('supplier.itemList', ['id' => $supplier->id])}}">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="numbers">
                                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Item Supply</p>
                                                        <h5 class="font-weight-bolder">
                                                            {{$totalItemSupply}}
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
                                    </a>
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="numbers">
                                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Purchase Order</p>
                                                        <h5 class="font-weight-bolder">
                                                            {{$totalPurchaseOrder}}
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
                        <p class="text-sm">Purchase Order</p>
                        {{-- <label for="">Purchase Order</label> --}}
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('supplier.update', ['id' => $supplier->id]) }}">
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
