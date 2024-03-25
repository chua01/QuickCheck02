@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
    <div class="row mt-4 mx-4">
        <div class="col-xl-6">
        </div>
        <div class="row">
            @for ($i = 0; $i < 5; $i++)
            <div class="col-md-3 mb-4">
                <a href=""> <!-- Replace $url with the URL you want to link to -->
                    <div class="card border border-1">
                        <div class="card-header mx-4 p-3 text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                <i class="fas fa-landmark opacity-10"></i>
                            </div>
                        </div>
                        <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">Salary</h6>
                            <span class="text-xs">Belong Interactive</span>
                            <hr class="horizontal dark my-3">
                            <h5 class="mb-0">+$2000</h5>
                        </div>
                    </div>
                </a>
            </div>
            
            @endfor
            {{-- <div class="col-md-3 ">
                <div class="card border border-1">
                    <div class="card-header mx-4 p-3 text-center">
                        <div
                            class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                            <i class="fab fa-paypal opacity-10"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center ">
                        <h6 class="text-center mb-0">Paypal</h6>
                        <span class="text-xs">Freelance Payment</span>
                        <hr class="horizontal dark my-3">
                        <h5 class="mb-0">$455.00</h5>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
