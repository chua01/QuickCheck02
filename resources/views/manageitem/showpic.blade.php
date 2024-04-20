
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ $item->name }}</h5>
                    </div>
                    <div class="card-body">
                        @if($item->pic)
                            <img src="{{ Storage::url($item->pic)  }}" alt="{{ $item->name }}" class="img-fluid">
                        @else
                            <p>No image available</p>
                        @endif
                        <p><strong>Description:</strong> {{ $item->description }}</p>
                        <p><strong>Quantity:</strong> {{ $item->quantity }}</p>
                        <p><strong>Unit:</strong> {{ $item->unit }}</p>
                        <p><strong>Price 1:</strong> {{ $item->price1 }}</p>
                        <p><strong>Price 2:</strong> {{ $item->price2 }}</p>
                        <p><strong>Price 3:</strong> {{ $item->price3 }}</p>
                        <p><strong>Min Quantity:</strong> {{ $item->minlevel }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
