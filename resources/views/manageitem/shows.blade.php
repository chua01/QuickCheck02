@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add Item'])

    <div class="container-fluid py-4">
        <form method="POST" action="{{ route('itemSupplier.store',['id' => $item->id]) }}" enctype="multipart/form-data">
            @csrf
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
                    /* Make the image square */
                    aspect-ratio: 1/1;
                    object-fit: cover;
                }

                .file-upload-image:hover {
                    opacity: 0.7;
                }
            </style>

            {{-- @style() --}}

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">New Item</p>
                                <div class="ms-auto">
                                    <a href="{{route('item.delete', ['id' => $item->id])}}" onclick="return confirm('Do you want to delete item {{$item->name}}? Item will be deleted permanently')" class="btn btn-danger btn-sm ms-auto">Delete</a>
                                    <a href="{{route('item.edit', ['id' => $item->id])}}" class="btn btn-info btn-sm ms-auto">Edit</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="file-upload-container">
                                                @if ($item->pic)
                                                    <img src="{{ Storage::url($item->pic) }}" alt="{{ $item->name }}"
                                                        class="img-fluid border rounded rounded-3">
                                                @else
                                                    <p>No image available</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <h4>{{ $item->name }}</h4>
                                        <p>{{ $item->description }}</p>
                                        <p>{{ $item->quantity }} {{ $item->unit }}</p>
                                        {{-- <label for="example-text-input" class="form-control-label">Item Name</label> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Price 1</label>
                                        <p>RM {{ $item->price1 }} </p>
                                        {{-- <input class="form-control" type="text" name="price1"> --}}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Price 2</label>
                                        <p>RM {{ $item->price2 }} </p>
                                        {{-- <input class="form-control" type="text" name="price1"> --}}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Price 3</label>
                                        <p>RM {{ $item->price3 }} </p>
                                        {{-- <input class="form-control" type="text" name="price1"> --}}
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <p>Suppliers</p>
                                @php
                                 $counter = 0;   
                                @endphp
                                @foreach($itemSuppliers as $itemSupplier)
                                @php
                                $counter+=1
                                @endphp
                                <div class="card-body mb-2 border rounded rounded-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            {{$counter}}
                                        </div>
                                        <div class="col-md-4">
                                            <h6>{{$itemSupplier->supplier->name}}</h6>
                                            <h6>
                                                <small>{{$itemSupplier->supplier->email}}</small>
                                            </h6>
                                            <h6>
                                                <small>{{$itemSupplier->supplier->contact->first()->contactnumber}}</small>
                                            </h6>
                                            
                                        </div>
                                        <div class="col-md-4">
                                            <h6>
                                                <small>{{$itemSupplier->supplier->address->location}}</small>
                                            </h6>
                                            <h6>
                                                <small> {{$itemSupplier->supplier->address->street}}</small>
                                            </h6>
                                            <h6>
                                                <small>{{$itemSupplier->supplier->address->code}}</small>
                                            </h6>
                                            <h6>
                                                <small>{{$itemSupplier->supplier->address->state}}</small>
                                            </h6>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{route('itemSupplier.destroy',['id' => $itemSupplier->id ])}}" class="btn btn-danger">remove</a>
                                            {{-- <button class="btn btn-danger">remove</button> --}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="row">
                                    <div class="col-md-8">

                                        <select name="supplier" class="form-control" id="supplier" required>
                                            <option value="">New Supplier</option>
                                            @foreach($suppliers as $supplier)
                                            <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-info">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        <script>
            function displayImage(event) {
                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var imgElement = document.getElementById('selected-image');
                        imgElement.src = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
