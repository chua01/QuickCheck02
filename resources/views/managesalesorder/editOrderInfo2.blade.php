@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])


@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add Sales Order'])

    <div class="container-fluid py-4">
        <form method="POST" action="{{ route('salesorder.updateOrderInfo2', ['id' => $quotation->id]) }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="card border">
                        <div class="card-body">
                            <div class="row my-1">
                                <div class="col">
                                    <p class="fw-bold small">Items Total</p>
                                </div>
                                <div class="col-auto" id="itemstotal">
                                    <p class="fw-bold small">RM 0.00</p>
                                </div>
                            </div>
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
                                            class="form-control no-border-bottom" placeholder="" onchange="update_item_info()" value="{{$quotation->extra_fee}}">
                                    </div>
                                </div>

                            </div>
                            <div class="row my-1">
                                <div class="col">
                                    <p class="fw-bold small">Total</p>
                                </div>
                                <div class="col-auto" id="totalAmount">
                                    <p class="fw-bold small">RM 0.00</p>
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
                                            class="form-control no-border-bottom" placeholder="" onchange="update_item_info()" value="{{$quotation->discount}}">
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
                            <button class="btn btn-primary btn-sm ms-auto" type="submit">Submit</button>
                        </div>
                    </div>

                </div>
            </div>
    </div>
    </form>
    @include('layouts.footers.auth.footer')
    </div>
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


        function update_item_info() {
            var totalAmount = {{$itemstotal}};
            total_amount_to_find = document.getElementById('totalAmount');
            discount_to_find = document.getElementById('discount');
            tax_to_find = document.getElementById('tax');
            amount_to_find = document.getElementById('amount');
            document.getElementById('itemstotal').querySelector("p").innerHTML = 'RM ' + parseFloat({{$itemstotal}}).toFixed(2);

            extra_fee = document.getElementById("extrafee").querySelector("input");
            if (!isNaN(totalAmount + parseFloat(extra_fee.value))) {
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

        document.addEventListener('DOMContentLoaded', function() {
            update_item_info();
        });
    </script>
@endsection
