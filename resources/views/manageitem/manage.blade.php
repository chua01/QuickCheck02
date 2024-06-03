@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Item Management'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6>Items</h6>
                            </div>
                            <div class="col-auto">
                                <a class="btn btn-success" type="button" href="{{ route('item.create') }}">New</a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search items...">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" id="itemContainer">
                            @foreach ($items as $item)
                                <div class="col-md-3 mb-4 item-card">
                                    <div class="card h-100 border border-1 position-relative">
                                        <a href="{{ route('item.show', ['id' => $item->id]) }}">
                                            <div class="card-header mx-4 p-3 text-center">
                                                <img src="{{ Storage::url($item->pic) }}" alt="Icon" class="img-fluid rounded border" style="width: 8rem; height: 8rem; object-fit: cover;">
                                            </div>
                                            <div class="card-body pt-0 p-3 text-center">
                                                <span class="text-center mb-0">
                                                    {{ $item->name }}
                                                    <h6></h6>
                                                </span>
                                                <span class="text-xs">ID: {{ $item->id }}</span><br>
                                                <span class="text-xs">RM {{ $item->price1 }}</span>
                                                <hr class="horizontal dark my-3">
                                                <h5 class="mb-0">{{ $item->quantity }} {{ $item->unit }}</h5>
                                            </div>
                                        </a>
                                        <a class="position-absolute top-0 end-0 mt-2 me-2" href="#">
                                            <i class="fas fa-thumbtack" style="{{ (1 == 1 ? '' : 'color: red;') }}"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const itemContainer = document.getElementById('itemContainer');
            const itemCards = itemContainer.getElementsByClassName('item-card');

            searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toLowerCase();
                Array.from(itemCards).forEach(function(card) {
                    const itemName = card.querySelector('.card-body span').textContent || card.querySelector('.card-body span').innerText;
                    if (itemName.toLowerCase().indexOf(filter) > -1) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>

    
@endsection
