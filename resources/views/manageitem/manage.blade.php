@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Item Management'])
    <div class="row mt-4 mx-4">
        {{-- <div class="col-xl-6">
            
        </div> --}}
        <div class="card">
            <div class="card-header pb-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h6>Items</h6>
                        {{-- <h6>Applications</h6> --}}
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-success" type="button" href="{{ route('user.create') }}">New</a>
                    </div>
                </div>
            </div>
            <div class="row">
                @for ($i = 0; $i < 15; $i++)
                    <div class="col-md-3 mb-4">
                        {{-- <button> new {{$i}}</button> --}}
                        <a href="">
                            <div class="card border border-1">
                                <div class="card-header mx-4 p-3 text-center">
                                    <div
                                        class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
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
            </div>
        </div>

    </div>
@endsection
