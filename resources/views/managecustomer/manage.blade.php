@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Customer Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6>Customer</h6>
                            {{-- <h6>Applications</h6> --}}
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-success" type="button" href="{{ route('customer.create') }}">New</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Contact
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Address</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div>
                                                    <img src="./img/team-1.jpg" class="avatar me-3" alt="image">
                                                </div>
                                                <a href="{{route('customer.show', ['id'=>$customer->id])}}">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0">{{ $customer->name }}</h6>
                                                        <p class="text-sm mb-0">{{ $customer->email }}</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="font-weight-bold mb-0">
                                                {{ $customer->contact->first()->contactnumber }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $customer->address->location }}</p>
                                            <p class="text-sm font-weight-bold mb-0">{{ $customer->address->code }}</p>
                                            <p class="text-sm font-weight-bold mb-0">{{ $customer->address->street }}</p>
                                            <p class="text-sm font-weight-bold mb-0">{{ $customer->address->state }}</p>
                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                <a class="text-sm font-weight-bold mb-0" href="{{route('customer.edit', ['id' => $customer->id])}}">Edit</a>
                                                <a class="text-sm font-weight-bold mb-0 ps-2">Delete</a>
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
