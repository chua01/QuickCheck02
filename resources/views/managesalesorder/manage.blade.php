@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Sales Order Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6>Sales Order</h6>
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-success" type="button" href="{{ route('salesorder.create') }}">New</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quotations as $quotation)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0">{{ $quotation->customer->name }}</h6>
                                                    <p class="text-sm mb-0">{{ $quotation->customer->email }}</p>
                                                    <p class="text-sm mb-0">{{ $quotation->customer->contact->first()->contactnumber }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="font-weight-bold mb-0">{{ $quotation->id }}</p>
                                        </td>
                                        <td>
                                            <p class="font-weight-bold mb-0">{{ $quotation->date }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">RM {{ $quotation->amount }}</p>
                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                <a class="text-sm font-weight-bold mb-0" href="{{ route('salesorder.show', ['id' => $quotation->id]) }}">Edit</a>
                                                <a href="#" class="text-sm font-weight-bold mb-0 ps-2" data-bs-toggle="modal" data-bs-target="#printModal" data-quotation-id="{{ $quotation->id }}">Print</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printModalLabel">Choose Document Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action print-option" data-doc-type="quotation">Quotation</a>
                        <a href="#" class="list-group-item list-group-item-action print-option" data-doc-type="invoice">Invoice</a>
                        <a href="#" class="list-group-item list-group-item-action print-option" data-doc-type="delivery_order">Delivery Order</a>
                        <a href="#" class="list-group-item list-group-item-action print-option" data-doc-type="sales_order">Sales Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var printModal = document.getElementById('printModal');
            var quotationId;

            printModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                quotationId = button.getAttribute('data-quotation-id');
            });

            var printOptions = document.querySelectorAll('.print-option');
            printOptions.forEach(function (option) {
                option.addEventListener('click', function () {
                    var docType = this.getAttribute('data-doc-type');
                    var url = "{{ url('salesorder/print') }}/" + docType + "/" + quotationId;
                    window.open(url, '_blank');
                    var modal = bootstrap.Modal.getInstance(printModal);
                    modal.hide();
                });
            });
        });
    </script>
@endsection
