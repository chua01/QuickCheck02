@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])


@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add Sales Order'])

    <div class="container-fluid py-4">
        <form method="POST" action="{{ route('salesorder.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card border">
                        <div class="card-body">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="checkbox" id="existingCustomer" name="existingCustomer"
                                                    value="1">
                                                <label for="checkboxName">Existing Customer</label>
                                            </div>
                                            <div id="customerForm" style="display: none;">
                                                <input class="form-control no-border-bottom" type="text"
                                                    placeholder="Enter item" list="customerList" name="customer"
                                                    onchange="update_customer_info(this.value)" />
                                                <datalist id="customerList">
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">
                                                            {{ $customer->name }}&#8288;
                                                        </option>
                                                    @endforeach
                                                </datalist>
                                            </div>

                                            <div class="form-group">
                                                <input id="name" class="form-control border-bottom" type="text"
                                                    name="name" placeholder="EG. KALVIN CHEN">
                                                <input id="email" class="form-control border-bottom" type="email"
                                                    name="email" placeholder="EG. chuakianpheng@gmail.com">
                                            </div>
                                            <div class="form-group">
                                                <label for="contactno" class="form-control-label">Contact No</label>
                                                <input id="contactno" class="form-control border-bottom" type="text"
                                                    name="contactno">
                                            </div>
                                            <div class="form-group">
                                                <label for="location" class="form-control-label">Billing Address</label>
                                                <input id="location" class="form-control border-bottom" type="text"
                                                    name="location" placeholder="location">
                                                <input id="code" class="form-control border-bottom" type="text"
                                                    name="code" placeholder="zipcode">
                                                <input id="street" class="form-control border-bottom" type="text"
                                                    name="street" placeholder="street">
                                                <input id="state" class="form-control border-bottom" type="text"
                                                    name="state" placeholder="state">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5 text-md-end">
                                            <div class="form-group">
                                                <input type="checkbox" id="checkboxName" name="checkboxName" value="1">
                                                <label for="checkboxName">Checkbox Label</label>
                                            </div>
                                            <div id="billingAddressForm" style="display: none;">
                                                <div class="form-group">
                                                    <label for="location" class="form-control-label">Delivery
                                                        Address</label>
                                                    <input id="location" class="form-control border-bottom" type="text"
                                                        name="delivery_location" placeholder="location">
                                                    <input id="code" class="form-control border-bottom" type="text"
                                                        name="delivery_code" placeholder="zipcode">
                                                    <input id="street" class="form-control border-bottom" type="text"
                                                        name="delivery_street" placeholder="street">
                                                    <input id="state" class="form-control border-bottom" type="text"
                                                        name="delivery_state" placeholder="state">
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="table-responsive p-0">
                                <div id="dropdownLists"></div>
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Items
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                unit price (RM)
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                quantities
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                amount</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <a id="addButton" class="h3">+</a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemList">

                                        <tr id="row0">
                                            <td>

                                                <div class="d-flex px-3 py-1">
                                                    <div class="d-flex flex-column justify-content-center" id="item0">
                                                        <p class="text-sm mb-0 h6"></p>
                                                        <input class="form-control no-border-bottom" type="text"
                                                            placeholder="Enter item" list="itemslist0"
                                                            name="orderitem[0][id]" onchange="update_item_info()" />
                                                        <datalist id="itemslist0">
                                                            @foreach ($items as $listitem)
                                                                <option value="{{ $listitem->id }}">
                                                                    {{ $listitem->name }}&#8288;({{ $listitem->unit }})
                                                                </option>
                                                            @endforeach
                                                        </datalist>
                                                    </div>



                                                </div>
                                            </td>
                                            <td>
                                                <input id="itemPrice0" type="number"
                                                    class="form-control no-border-bottom" placeholder="0.00"
                                                    value="0.00" name="orderitem[0][price]" onchange="update_item_info()">

                                            </td>
                                            <td>

                                                <div class="row">
                                                    <div class="col-4" id="itemQuantity0">
                                                        <input type="number" class="form-control no-border-bottom"
                                                            style="text-align: right;" value="0"
                                                            name="orderitem[0][quantity]" placeholder="0"
                                                            onchange="update_item_info()">
                                                    </div>
                                                    <div class="col-4" id="itemUnit0">
                                                        <p class="text-sm mb-0 h6"></p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <div id="totalPrice0">
                                                    <p class="text-sm font-weight-bold mb-0"></p>
                                                </div>
                                            </td>
                                            <td class="align-middle text-end">
                                                <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                    <a onclick="delete_row('row0')"
                                                        class="text-sm font-weight-bold mb-0 ps-2">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card border">
                                <div class="card-body">
                                    <div class="row my-1">
                                        <div class="col">
                                            <p class="fw-bold small">Extra Fee</p>
                                        </div>
                                        <div class="col-auto" id="extrafee">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="">RM</span>
                                                </div>
                                                <input name="extrafee" style="text-align: right;" type="number"
                                                    class="form-control no-border-bottom" placeholder="" onchange="update_item_info()">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row my-1">
                                        <div class="col">
                                            <p class="fw-bold small">Total</p>
                                        </div>
                                        <div class="col-auto" id="totalAmount">
                                            <p class="fw-bold small">RM 404.00</p>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col">
                                            <p class="fw-bold small">Discount</p>
                                        </div>
                                        <div class="col-auto" id="discount">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="">RM</span>
                                                </div>
                                                <input name="discount" style="text-align: right;" type="number"
                                                    class="form-control no-border-bottom" placeholder="" onchange="update_item_info()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col">
                                            <p class="fw-bold small">Tax</p>
                                        </div>
                                        <div class="col-auto" id="tax">
                                            <p class="fw-bold small">0</p>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col">
                                            <p class="fw-bold small">Amount</p>
                                        </div>
                                        <div class="col-auto" id="amount">
                                            <p class="fw-bold small">RM 405.00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary btn-sm ms-auto" type="submit">Submit</button>

                        </div>

                    </div>
                </div>
            </div>
    </div>
    </form>
    @include('layouts.footers.auth.footer')
    </div>

    <script>
        // Listen for changes in the checkbox
        document.getElementById('checkboxName').addEventListener('change', function() {
            var billingAddressForm = document.getElementById('billingAddressForm');
            // Toggle the display of the billing address form based on the checkbox state
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
            var customerFrom = document.getElementById('customerForm');

            console.log(name.value)
            if (this.checked) {
                customerFrom.style.display = 'block';
                customerFrom.querySelector('input').value = '';
                name.disabled = true;
                email.disabled = true;
                contactno.disabled = true;
                location.disabled = true;
                code.disabled = true;
                street.disabled = true;
                state.disabled = true;
            } else {
                customerFrom.style.display = 'none';
                // Make fields editable when existing customer is not selected
                name.disabled = false;
                email.disabled = false;
                contactno.disabled = false;
                location.disabled = false;
                code.disabled = false;
                street.disabled = false;
                state.disabled = false;
                // Clear the values
                name.value = '';
                email.value = '';
                contactno.value = '';
                location.value = '';
                code.value = '';
                street.value = '';
                state.value = '';
            }
        })
    </script>
    <style>
        /* Add bottom border to form inputs */
        .border-bottom {
            border: none;
            border-bottom: 1px solid #ced4da;
            border-radius: 0;
            padding: 0;
            margin: 0;
            background-color: transparent;
        }
    </style>
    <style>
        /* Add bottom border to form inputs */
        .no-border-bottom {
            border: none;
            /* border-bottom: 1px solid #ced4da; */
            border-radius: 0;
            padding: 0;
            margin: 0;
            background-color: transparent;
        }
    </style>

    <script>
        // Display alert if any validation errors occur
        @if ($errors->any())
            alert('{{ $errors->first() }}');
        @endif
    </script>
    <script>
        document.getElementById('extrafee').addEventListener('input', function(e) {
            let value = parseFloat(e.target.value).toFixed(2);
            e.target.value = value;
        });

        document.getElementById('extrafee').addEventListener('blur', function(e) {
            let value = parseFloat(e.target.value).toFixed(2);
            e.target.value = value;
        });
        items = {!! json_encode($items) !!};
        console.log(items);
        var index = 0;

        document.getElementById('addButton').addEventListener('click', function() {
            var dropdownLists = document.getElementById('itemList');
            var newDropdown = document.createElement('tr');
            index = index + 1;
            newDropdown.id = `row${index}`;
            new_row = `<tr id="row${index}">
                        <td>

                        <div class="d-flex px-3 py-1">
                            <div class="d-flex flex-column justify-content-center" id="item${index}">
                                <p class="text-sm mb-0 h6"></p>
                                <input class="form-control no-border-bottom"
                                    type="text" placeholder="Enter item" value=""
                                    list="itemslist${index}" name="orderitem[${index}][id]" onchange="update_item_info()"/>
                                <datalist id="itemslist${index}">
                                    @foreach ($items as $listitem)
                                        <option value="{{ $listitem->id }}">
                                            {{ $listitem->name }}&#8288;({{ $listitem->unit }})
                                        </option>
                                    @endforeach
                                </datalist>
                            </div>



                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control no-border-bottom"
                            placeholder="0.00" id="itemPrice${index}" value="" name="orderitem[${index}][price]" onchange="update_item_info()">

                    </td>
                    <td>

                        <div class="row">
                            <div class="col-4" id="itemQuantity${index}">
                                <input type="number" class="form-control no-border-bottom"
                                    style="text-align: right;" onchange="update_item_info()"
                                    name="orderitem[${index}][quantity]" placeholder="0">
                            </div>
                            <div class="col-4" id="itemUnit${index}">
                                <p class="text-sm mb-0 h6"></p>
                            </div>
                        </div>
                    </td>

                    <td class="align-middle text-center text-sm">
                        <div id="totalPrice${index}">
                            <p class="text-sm font-weight-bold mb-0">RM</p>
                            </div>
                    </td>
                    <td class="align-middle text-end">
                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                            <a onclick="delete_row('row${index}')"
                                class="text-sm font-weight-bold mb-0 ps-2">Delete</a>
                        </div>
                    </td>
                </tr>`
            newDropdown.innerHTML = new_row
            dropdownLists.appendChild(newDropdown);
            update_item_info();
        });

        function update_item_info() {
            var totalAmount = 0;
            total_amount_to_find = document.getElementById('totalAmount');
            discount_to_find = document.getElementById('discount');
            tax_to_find = document.getElementById('tax');
            amount_to_find = document.getElementById('amount');
            for (var i = 0; i <= index; i++) {
                item_id = "item" + i;
                unit_id = "itemUnit" + i;
                price_id = "itemPrice" + i;
                total_price_id = "totalPrice" + i;
                quantity_id = "itemQuantity" + i;

                item_to_find = document.getElementById(item_id);
                unit_to_find = document.getElementById(unit_id);
                price_to_find = document.getElementById(price_id);
                total_price_to_find = document.getElementById(total_price_id);
                quantity_to_find = document.getElementById(quantity_id);

                if (item_to_find) {
                    item_name = item_to_find.querySelector("p");
                    input_field = item_to_find.querySelector("input");
                    unit = unit_to_find.querySelector("p")
                    totalPrice = total_price_to_find.querySelector("p")
                    quantity = quantity_to_find.querySelector("input")

                    if (input_field.defaultValue === input_field.value) {
                        console.log('same same na' + input_field.value);
                    } else {
                        console.log('not same na' + input_field.value);
                        item_id = parseInt(input_field.value) - 1;
                        input_field.defaultValue = input_field.value;
                        item_name.innerHTML = items[item_id].name;
                        unit.innerHTML = items[item_id].unit;
                        quantity.value = 0;
                        price_to_find.value = parseFloat(items[item_id].price1).toFixed(2);
                    }
                    totalPrice.innerHTML = parseFloat(price_to_find.value * quantity.value).toFixed(2);
                    if (!isNaN(parseFloat(price_to_find.value) * parseInt(quantity.value, 10))) {

                        totalAmount += parseFloat(price_to_find.value) * parseInt(quantity.value, 10);
                    }

                }
            }
            extra_fee = document.getElementById("extrafee").querySelector("input");
            if (!isNaN(totalAmount + parseFloat(extra_fee.value))) {

                // totalAmount += parseFloat(price_to_find.value) * parseInt(quantity.value, 10);
                console.log('howdy');
                console.log(extra_fee.value);
                console.log(totalAmount);
                totalAmount += parseFloat(extra_fee.value);
            }
            total_amount = total_amount_to_find.querySelector("p");
            total_amount.innerHTML = 'RM ' + parseFloat(totalAmount).toFixed(2);
            discount = discount_to_find.querySelector("input");
            if (!isNaN(totalAmount - parseFloat(discount.value))) {
                totalAmount -= parseFloat(discount.value);
            }
            console.log(totalAmount, total_amount_to_find);
            tax = tax_to_find.querySelector("p");
            tax.innerHTML = 'RM ' + parseFloat(totalAmount * 0.06).toFixed(2);
            amount = document.getElementById('amount').querySelector("p");
            amount.innerHTML = 'RM ' + parseFloat(totalAmount * 1.06).toFixed(2);

        };

        function update_customer_info(id) {
            customers = {!! json_encode($customers) !!};
            console.log(customers);

            // $("#name")
            var name = document.getElementById('name');
            var email = document.getElementById('email');
            var contactno = document.getElementById('contactno');
            var location = document.getElementById('location');
            var code = document.getElementById('code');
            var street = document.getElementById('street');
            var state = document.getElementById('state');
            var customerFrom = document.getElementById('customerForm');

            id = id - 1;
            name.value = customers[id]['name'];
            console.log(name.value + customers[id]['name'] + name);
            email.value = customers[id]['email'];
            contactno.value = customers[id]['contact'][0]['contactnumber'];
            location.value = customers[id]['address']['location'];
            code.value = customers[id]['address']['code'];
            street.value = customers[id]['address']['street'];
            state.value = customers[id]['address']['state'];
        }

        function delete_row(id) {
            row_to_delete = document.getElementById(id);
            if (row_to_delete) {
                row_to_delete.remove();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            update_item_info();
        });
    </script>
@endsection
