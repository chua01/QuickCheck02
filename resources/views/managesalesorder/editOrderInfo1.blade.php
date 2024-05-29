@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add Sales Order'])

    <div class="container-fluid py-4">
        <form method="POST" action="{{ route('salesorder.updateOrderInfo1', ['id' => $quotation->id]) }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card border">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="checkbox" id="existingCustomer" name="existingCustomer"
                                            value="1" checked>
                                        <label for="existingCustomer">Existing Customer</label>
                                    </div>
                                    <div id="customerForm">
                                        <input class="form-control no-border-bottom" type="text"
                                            placeholder="Enter item" list="customerList" name="customer"
                                            onchange="update_customer_info(this.value)"  value="{{$quotation->customer_id}}"/>
                                        <datalist id="customerList">
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}" 
                                                    {{ $customer->id == $quotation->customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}&#8288;
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
                                            {{ $quotation->delivery == 'yes' ? 'checked' : '' }}>
                                        <label for="checkboxName">Delivery Required</label>
                                    </div>
                                    <div id="billingAddressForm" style="{{ $quotation->delivery == 'yes' ? 'display: block;' : 'display: none;' }}">
                                        <div class="form-group">
                                            <label for="delivery_location" class="form-control-label">Delivery Address</label>
                                            <input id="delivery_location" class="form-control border-bottom" type="text"
                                                name="delivery_location" placeholder="location" value="{{($quotation->delivery == 'yes'? $quotation->deliveryaddress->location:null)}}">
                                            <input id="delivery_code" class="form-control border-bottom" type="text"
                                                name="delivery_code" placeholder="zipcode" value="{{($quotation->delivery == 'yes'? $quotation->deliveryaddress->code:null)}}">
                                            <input id="delivery_street" class="form-control border-bottom" type="text"
                                                name="delivery_street" placeholder="street" value="{{($quotation->delivery == 'yes'? $quotation->deliveryaddress->street:null)}}">
                                            <input id="delivery_state" class="form-control border-bottom" type="text"
                                                name="delivery_state" placeholder="state" value="{{($quotation->delivery == 'yes'? $quotation->deliveryaddress->state:null)}}">
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
        var customer_id = {{$quotation->customer_id}};
        document.getElementById('checkboxName').addEventListener('change', function() {
            var billingAddressForm = document.getElementById('billingAddressForm');
            if (this.checked) {
                billingAddressForm.style.display = 'block';
            } else {
                billingAddressForm.style.display = 'none';
            }
        });

        document.getElementById('existingCustomer').addEventListener('change', function() {
            var name = document.getElementById('name');
            var email = document.getElementById('email');
            var contactno = document.getElementById('contactno');
            var location = document.getElementById('location');
            var code = document.getElementById('code');
            var street = document.getElementById('street');
            var state = document.getElementById('state');
            var customerForm = document.getElementById('customerForm');

            if (this.checked) {
                customerForm.style.display = 'block';
                name.disabled = true;
                email.disabled = true;
                contactno.disabled = true;
                location.disabled = true;
                code.disabled = true;
                street.disabled = true;
                state.disabled = true;
                update_customer_info(customer_id); 
            } else {
                customerForm.style.display = 'none';
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
            var defaultCustomerId = '{{ $quotation->customer->id }}';
            document.getElementById('existingCustomer').checked = true;
            document.getElementById('customerForm').style.display = 'block';
            document.getElementById('name').disabled = true;
            document.getElementById('email').disabled = true;
            document.getElementById('contactno').disabled = true;
            document.getElementById('location').disabled = true;
            document.getElementById('code').disabled = true;
            document.getElementById('street').disabled = true;
            document.getElementById('state').disabled = true;
            update_customer_info(defaultCustomerId);

            var deliveryCheckbox = document.getElementById('checkboxName');
            var billingAddressForm = document.getElementById('billingAddressForm');
            if (deliveryCheckbox.checked) {
                billingAddressForm.style.display = 'block';
            } else {
                billingAddressForm.style.display = 'none';
            }
        });

        function update_customer_info(id) {
            customers = {!! json_encode($customers) !!};

            if (id) {
                var customer = customers.find(c => c.id == id);
                var name = document.getElementById('name');
                var email = document.getElementById('email');
                var contactno = document.getElementById('contactno');
                var location = document.getElementById('location');
                var code = document.getElementById('code');
                var street = document.getElementById('street');
                var state = document.getElementById('state');

                if (customer) {
                    name.value = customer.name;
                    email.value = customer.email;
                    contactno.value = customer.contact[0]?.contactnumber || '';
                    location.value = customer.address.location;
                    code.value = customer.address.code;
                    street.value = customer.address.street;
                    state.value = customer.address.state;
                }
                customer_id = id;
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
