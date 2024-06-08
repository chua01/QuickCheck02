@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])

    <div class="container-fluid py-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Customer Orders Chart -->
            <div class="col-12 col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Customer Orders</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="customerOrdersChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Purchase Orders Chart -->
            <div class="col-12 col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Purchase Orders</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="purchaseOrdersChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Customers Chart -->
            <div class="col-12 col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Customers</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="customersChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Suppliers Chart -->
            <div class="col-12 col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Suppliers</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="suppliersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <canvas id="salesOverviewChart"></canvas>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('salesOverviewChart').getContext('2d');
    var salesOverviewChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($salesOverview['labels']), // Dates or time periods
            datasets: [
                {
                    label: '2023',
                    data: @json($salesOverview['data_2023']),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: '2024',
                    data: @json($salesOverview['data_2024']),
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: { beginAtZero: true, grid: { display: false } },
                y: { beginAtZero: true }
            }
        }
    });
});
</script>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Customer Orders Chart
            var ctxCustomerOrders = document.getElementById('customerOrdersChart').getContext('2d');
            var customerOrdersChart = new Chart(ctxCustomerOrders, {
                type: 'line',
                data: {
                    labels: @json($customerOrderData['labels']),
                    datasets: [{
                        label: 'Customer Orders',
                        data: @json($customerOrderData['amounts']),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    }]
                },
                options: {
                    scales: {
                        x: { beginAtZero: true },
                        y: { beginAtZero: true }
                    }
                }
            });

            // Purchase Orders Chart
            var ctxPurchaseOrders = document.getElementById('purchaseOrdersChart').getContext('2d');
            var purchaseOrdersChart = new Chart(ctxPurchaseOrders, {
                type: 'line',
                data: {
                    labels: @json($purchaseOrderData['labels']),
                    datasets: [{
                        label: 'Purchase Orders',
                        data: @json($purchaseOrderData['amounts']),
                        borderColor: 'rgba(153, 102, 255, 1)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    }]
                },
                options: {
                    scales: {
                        x: { beginAtZero: true },
                        y: { beginAtZero: true }
                    }
                }
            });

            // Customers Chart
            var ctxCustomers = document.getElementById('customersChart').getContext('2d');
            var customersChart = new Chart(ctxCustomers, {
                type: 'bar',
                data: {
                    labels: @json($customers->pluck('name')),
                    datasets: [{
                        label: 'Customers',
                        data: @json($customers->pluck('id')),
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: { beginAtZero: true },
                        y: { beginAtZero: true }
                    }
                }
            });

            // Suppliers Chart
            var ctxSuppliers = document.getElementById('suppliersChart').getContext('2d');
            var suppliersChart = new Chart(ctxSuppliers, {
                type: 'bar',
                data: {
                    labels: @json($suppliers->pluck('name')),
                    datasets: [{
                        label: 'Suppliers',
                        data: @json($suppliers->pluck('id')),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: { beginAtZero: true },
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
@endsection
