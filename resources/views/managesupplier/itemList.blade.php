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
                        <a class="btn btn-success" type="button" href="{{ route('item.create') }}">New</a>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($items as $item)
                    <div class="col-md-3 mb-4">
                        <div class="card border border-1 position-relative">
                            <a href="{{route('item.show', [ 'id' => $item->item->id])}}">
                                <div class="card-header mx-4 p-3 text-center">
                                    <img src="{{ Storage::url($item->item->pic) }}" alt="Icon" class="opacity-10 rounded border " style="width: 8rem; height: 8rem;">
                                </div>
                                
                                
                                <div class="card-body pt-0 p-3 text-center">
                                    <span class="text-center mb-0">
                                        {{$item->item->name}}
                                            <h6 >
                                        </h6>
                                        </span>
                                    <span class="text-xs">ID: {{$item->item->id}}</span><br>
                                    <span class="text-xs">RM {{$item->item->price1}}</span>
                                    <hr class="horizontal dark my-3">
                                    <h5 class="mb-0 {{($item->item->quantity<$item->item->minlevel?'text-danger':null)}}" >{{$item->item->quantity}} {{$item->item->unit}}</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            
        </div>

    </div>
@endsection
