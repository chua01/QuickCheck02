@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Purchase Order Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6>Purchase Order</h6>
                            {{-- <h6>Applications</h6> --}}
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-success" type="button" href="{{route('purchaseorder.create')}}">New</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">supplier
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        ID
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Date
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        amount</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseorders as $purchaseorder)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0">{{$purchaseorder->supplier->name}}</h6>
                                                    <p class="text-sm mb-0">{{$purchaseorder->supplier->email}}</p>
                                                    <p class="text-sm mb-0">{{$purchaseorder->supplier->contact->first()->contactnumber}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="font-weight-bold mb-0">
                                               {{$purchaseorder->id}}</p>
                                        </td>
                                        <td>
                                            <p class="font-weight-bold mb-0">
                                               {{$purchaseorder->date}}</p>
                                        </td>
                                        {{-- <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">sdf</p>
                                        </td> --}}
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">RM {{$purchaseorder->amount}}</p>
                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                <a class="text-sm font-weight-bold mb-0" href="{{route('purchaseorder.show', ['id' => $purchaseorder->id])}}">Edit</a>
                                                <a class="text-sm font-weight-bold mb-0 ps-2" target="_blank" href="{{route('purchaseorder.print', ['id' => $purchaseorder->id])}}">Print</a>
                                                {{-- <p class="text-sm font-weight-bold mb-0 ps-2">Print</p> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
