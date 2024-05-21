@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add Sales Order'])

    <div class="container-fluid py-4">
        <form method="POST" action="{{ route('supplier.store') }}">
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
                                                <input id="name" class="form-control border-bottom" type="text"
                                                    name="name" placeholder="EG. CHUA KIAN PHENG">
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
                                            <button class="btn btn-primary btn-sm">Print</button>
                                            <div class="form-group">
                                                <input type="checkbox" id="checkboxName" name="checkboxName" value="1">
                                                <label for="checkboxName">Checkbox Label</label>
                                            </div>
                                            <div id="billingAddressForm" style="display: none;">
                                                <div class="form-group">
                                                    <label for="location" class="form-control-label">Delivery
                                                        Address</label>
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


                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="table-responsive p-0">
                                <div id="dropdownLists"></div>
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
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

                                        <tr>
                                            <td>

                                                <div class="d-flex px-3 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p id="itemName" class="text-sm mb-0 h6"></p>
                                                        <input id="itemId" class="form-control no-border-bottom"
                                                            type="text" placeholder="Enter item" value=""
                                                            list="itemslist" />
                                                        <datalist id="itemslist">
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
                                                    placeholder="0.00" value="">
                                                {{-- <p class="font-weight-bold mb-0">
                                                    RM 39.90</p> --}}
                                            </td>
                                            <td>
                                                {{-- <p class="font-weight-bold mb-0">
                                                    10 units</p> --}}
                                                <div class="row">
                                                    <div class="col-4">
                                                        <input type="number" class="form-control no-border-bottom"
                                                            style="text-align: right;" value="{" placeholder="0">
                                                    </div>
                                                    <div class="col-4">
                                                        <p id="itemUnit" class="text-sm mb-0 h6"></p>

                                                    </div>
                                                </div>
                                            </td>
                                            {{-- <td class="align-middle text-center text-sm">
                                                    <p class="text-sm font-weight-bold mb-0">sdf</p>
                                                </td> --}}
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">RM</p>
                                            </td>
                                            <td class="align-middle text-end">
                                                <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                    {{-- <p class="text-sm font-weight-bold mb-0 ps-2">Delete</p> --}}
                                                    <a href=""
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
                                        <div class="col-auto">
                                            <p class="fw-bold small">RM 5.00</p>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col">
                                            <p class="fw-bold small">Total</p>
                                        </div>
                                        <div class="col-auto">
                                            <p class="fw-bold small">RM 404.00</p>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col">
                                            <p class="fw-bold small">Discount</p>
                                        </div>
                                        <div class="col-auto">
                                            <p class="fw-bold small">0</p>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col">
                                            <p class="fw-bold small">Tax</p>
                                        </div>
                                        <div class="col-auto">
                                            <p class="fw-bold small">0</p>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col">
                                            <p class="fw-bold small">Amount</p>
                                        </div>
                                        <div class="col-auto">
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
        document.addEventListener('DOMContentLoaded', function() {
            console.log('testing');

            console.log('fish');
            console.log(" what the fuck");
            var itemName = document.getElementById('itemName');
            var itemIdInput = document.getElementById('itemId');
            var itemsList = document.getElementById('itemslist');

            itemIdInput.addEventListener('input', function(e) {
                console.log("Input changed");
                var value = e.target.value;
                console.log("Input value:", value);
                var option = itemsList.querySelector('option[value="' + value + '"]');
                if (option) {
                    console.log("Option found:", option);
                    var optionText = option.textContent;
                    console.log("Option text:", optionText);
                    var optionParts = optionText.split(
                        '\u2060'); // Split text content by invisible character
                    console.log("Option parts:", optionParts);
                    itemName.textContent = optionParts[0]; // First part is item name
                    if (optionParts[1]) {
                        var itemUnit = document.getElementById('itemUnit');
                        if (itemUnit) {
                            itemUnit.textContent = optionParts[1]; // Second part is unit
                        }
                    }
                } else {
                    console.log("Option not found");
                    itemName.textContent = '';
                    var itemUnit = document.getElementById('itemUnit');
                    if (itemUnit) {
                        itemUnit.textContent = '';
                    }
                }
            });

        });

        document.getElementById('addButton').addEventListener('click', function() {
            var dropdownLists = document.getElementById('itemList');
            var newDropdown = document.createElement('tr');
            newDropdown.classList.add('form-group');
            newDropdown.innerHTML = `
            <tr>
                                            <td>

                                                <div class="d-flex px-3 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p id="itemName" class="text-sm mb-0 h6"></p>
                                                        <input id="itemId" class="form-control no-border-bottom"
                                                            type="text" placeholder="Enter item" value=""
                                                            list="itemslist" />
                                                        <datalist id="itemslist">
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
                                                    placeholder="0.00" value="">
                                                {{-- <p class="font-weight-bold mb-0">
                                                    RM 39.90</p> --}}
                                            </td>
                                            <td>
                                                {{-- <p class="font-weight-bold mb-0">
                                                    10 units</p> --}}
                                                <div class="row">
                                                    <div class="col-4">
                                                        <input type="number" class="form-control no-border-bottom"
                                                            style="text-align: right;" value="{" placeholder="0">
                                                    </div>
                                                    <div class="col-4">
                                                        <p id="itemUnit" class="text-sm mb-0 h6"></p>

                                                    </div>
                                                </div>
                                            </td>
                                            {{-- <td class="align-middle text-center text-sm">
                                                    <p class="text-sm font-weight-bold mb-0">sdf</p>
                                                </td> --}}
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">RM</p>
                                            </td>
                                            <td class="align-middle text-end">
                                                <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                    {{-- <p class="text-sm font-weight-bold mb-0 ps-2">Delete</p> --}}
                                                    <a href=""
                                                        class="text-sm font-weight-bold mb-0 ps-2">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                `;
            dropdownLists.appendChild(newDropdown);
        });
    </script>
@endsection
