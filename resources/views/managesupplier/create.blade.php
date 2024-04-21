@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add Supplier'])
  
    <div class="container-fluid py-4">
        <form method="POST" action="{{ route('supplier.store') }}">
            @csrf

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
                            <p class=" text-sm">supplier Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-control-label">Name</label>
                                        <input id="name" class="form-control" type="text" name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contactno" class="form-control-label">Contact No</label>
                                        <input id="contactno" class="form-control" type="text" name="contactno">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-control-label">Email</label>
                                        <input id="email" class="form-control" type="email" name="email">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="location" class="form-control-label">Location</label>
                                        <input id="location" class="form-control" type="text" name="location">
                                    </div>
                                    <div class="form-group">
                                        <label for="code" class="form-control-label">Code</label>
                                        <input id="code" class="form-control" type="text" name="code">
                                    </div>
                                    <div class="form-group">
                                        <label for="street" class="form-control-label">Street</label>
                                        <input id="street" class="form-control" type="text" name="street">
                                    </div>
                                    <div class="form-group">
                                        <label for="state" class="form-control-label">State</label>
                                        <input id="state" class="form-control" type="text" name="state">
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

    <script>
        // Display alert if any validation errors occur
        @if ($errors->any())
            alert('{{$errors->first()}}');
        @endif
    </script>
@endsection
