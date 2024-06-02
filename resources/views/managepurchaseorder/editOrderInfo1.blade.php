@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add Purchase Order'])

    <div class="container-fluid py-4">
        <form method="POST" action="{{ route('purchaseorder.updateOrderInfo1', ['id' => $purchaseorder->id]) }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card border">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="checkbox" id="existingsupplier" name="existingsupplier"
                                            value="1" checked>
                                        <label for="existingsupplier">Existing supplier</label>
                                    </div>
                                    <div id="supplierForm">
                                        <input class="form-control no-border-bottom" type="text"
                                            placeholder="Enter item" list="supplierList" name="supplier"
                                            onchange="update_supplier_info(this.value)"  value="{{$purchaseorder->supplier_id}}"/>
                                        <datalist id="supplierList">
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" 
                                                    {{ $supplier->id == $purchaseorder->supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}&#8288;
                                                </option>
                                            @endforeach
                                        </datalist>
                                    </div>

                                    <div class="form-group">
                                        <input id="name" class="form-control border-bottom" type="text"
                                            name="name" placeholder="EG. KALVIN CHEN" disabled>
                                        <input id="email" class="form-control border-bottom" type="email"
                                            name="email" placeholder="EG. chuakianpheng@gmail.com" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="contactno" class="form-control-label">Contact No</label>
                                        <input id="contactno" class="form-control border-bottom" type="text"
                                            name="contactno" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="location" class="form-control-label">Billing Address</label>
                                        <input id="location" class="form-control border-bottom" type="text"
                                            name="location" placeholder="location" disabled>
                                        <input id="code" class="form-control border-bottom" type="text"
                                            name="code" placeholder="zipcode" disabled>
                                        <input id="street" class="form-control border-bottom" type="text"
                                            name="street" placeholder="street" disabled>
                                        <input id="state" class="form-control border-bottom" type="text"
                                            name="state" placeholder="state" disabled>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-5 text-md-end">
                                    <button class="btn btn-primary btn-sm">Submit</button>
                                    <div class="form-group">
                                        <input type="checkbox" id="checkboxName" name="checkboxName" value="1" 
                                            {{ $purchaseorder->delivery == 'yes' ? 'checked' : '' }}>
                                        <label for="checkboxName">Delivery Required</label>
                                    </div>
                                    <div id="billingAddressForm" style="{{ $purchaseorder->delivery == 'yes' ? 'display: block;' : 'display: none;' }}">
                                        <div class="form-group">
                                            <label for="delivery_location" class="form-control-label">Delivery Address</label>
                                            <input id="delivery_location" class="form-control border-bottom" type="text"
                                                name="delivery_location" placeholder="location" value="{{($purchaseorder->delivery == 'yes'? $purchaseorder->deliveryaddress->location:null)}}">
                                            <input id="delivery_code" class="form-control border-bottom" type="text"
                                                name="delivery_code" placeholder="zipcode" value="{{($purchaseorder->delivery == 'yes'? $purchaseorder->deliveryaddress->code:null)}}">
                                            <input id="delivery_street" class="form-control border-bottom" type="text"
                                                name="delivery_street" placeholder="street" value="{{($purchaseorder->delivery == 'yes'? $purchaseorder->deliveryaddress->street:null)}}">
                                            <input id="delivery_state" class="form-control border-bottom" type="text"
                                                name="delivery_state" placeholder="state" value="{{($purchaseorder->delivery == 'yes'? $purchaseorder->deliveryaddress->state:null)}}">
                                        </div>
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
        var supplier_id = {{$purchaseorder->supplier_id}};
      
        document.getElementById('existingsupplier').addEventListener('change', function() {
            var name = document.getElementById('name');
            var email = document.getElementById('email');
            var contactno = document.getElementById('contactno');
            var location = document.getElementById('location');
            var code = document.getElementById('code');
            var street = document.getElementById('street');
            var state = document.getElementById('state');
            var supplierForm = document.getElementById('supplierForm');

            if (this.checked) {
                supplierForm.style.display = 'block';
                name.disabled = true;
                email.disabled = true;
                contactno.disabled = true;
                location.disabled = true;
                code.disabled = true;
                street.disabled = true;
                state.disabled = true;
                update_supplier_info(supplier_id); 
            } else {
                supplierForm.style.display = 'none';
                name.disabled = false;
                email.disabled = false;
                contactno.disabled = false;
                location.disabled = false;
                code.disabled = false;
                street.disabled = false;
                state.disabled = false;
                name.value = '';
                email.value = '';
                contactno.value = '';
                location.value = '';
                code.value = '';
                street.value = '';
                state.value = '';
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            var defaultsupplierId = '{{ $purchaseorder->supplier->id }}';
            document.getElementById('existingsupplier').checked = true;
            document.getElementById('supplierForm').style.display = 'block';
            document.getElementById('name').disabled = true;
            document.getElementById('email').disabled = true;
            document.getElementById('contactno').disabled = true;
            document.getElementById('location').disabled = true;
            document.getElementById('code').disabled = true;
            document.getElementById('street').disabled = true;
            document.getElementById('state').disabled = true;
            update_supplier_info(defaultsupplierId);

            var deliveryCheckbox = document.getElementById('checkboxName');
            var billingAddressForm = document.getElementById('billingAddressForm');
            if (deliveryCheckbox.checked) {
                billingAddressForm.style.display = 'block';
            } else {
                billingAddressForm.style.display = 'none';
            }
        });

        function update_supplier_info(id) {
            suppliers = {!! json_encode($suppliers) !!};

            if (id) {
                var supplier = suppliers.find(c => c.id == id);
                var name = document.getElementById('name');
                var email = document.getElementById('email');
                var contactno = document.getElementById('contactno');
                var location = document.getElementById('location');
                var code = document.getElementById('code');
                var street = document.getElementById('street');
                var state = document.getElementById('state');

                if (supplier) {
                    name.value = supplier.name;
                    email.value = supplier.email;
                    contactno.value = supplier.contact[0]?.contactnumber || '';
                    location.value = supplier.address.location;
                    code.value = supplier.address.code;
                    street.value = supplier.address.street;
                    state.value = supplier.address.state;
                }
                supplier_id = id;
            }
        }
    </script>

    <style>
        .border-bottom {
            border: none;
            border-bottom: 1px solid #ced4da;
            border-radius: 0;
            padding: 0;
            margin: 0;
            background-color: transparent;
        }

        .no-border-bottom {
            border: none;
            border-radius: 0;
            padding: 0;
            margin: 0;
            background-color: transparent;
        }
    </style>

    <script>
        @if ($errors->any())
            alert('{{ $errors->first() }}');
        @endif
    </script>
@endsection
