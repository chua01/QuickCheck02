@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add Item'])

    <div class="container-fluid py-4">
        <form method="POST" action="" enctype="multipart/form-data">
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
                                <button class="btn btn-primary btn-sm ms-auto" type="submit">Submit</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-6">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Item Photo</label>
                                        <div class="file-upload-container">
                                            <input class="form-control file-upload-input" type="file" id="photo" name="photo" onchange="displayImage(event)">
                                            <img id="selected-image" class="file-upload-image" src="{{ asset('img/plus.png') }}" alt="Upload Photo">
                                        </div>
                                    </div>
                                </div>
                                
                                <script>
                                    function displayImage(event) {
                                        var input = event.target;
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();
                                            reader.onload = function (e) {
                                                var imgElement = document.getElementById('selected-image');
                                                imgElement.src = e.target.result;
                                            };
                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>
                                

                              
                            </div>
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Item Name</label>
                                        <input class="form-control" type="text" name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Description</label>
                                        <input class="form-control" type="email" name="description">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Quantity</label>
                                        <input class="form-control" type="number" name="quantity">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">unit</label>
                                        <input class="form-control" type="text" name="unit">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Price 1</label>
                                        <input class="form-control" type="text" name="price1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Price 2</label>
                                        <input class="form-control" type="text" name="price2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Price 3</label>
                                        <input class="form-control" type="text" name="price3">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Min Quantity</label>
                                        <input class="form-control" type="text" name="minlevel">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Item Photo</label>
                                        <input class="form-control" type="file" name="photo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
