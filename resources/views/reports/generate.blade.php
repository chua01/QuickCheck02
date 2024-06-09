<!-- resources/views/reports/generate.blade.php -->
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Report Summary'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Report Summary from {{ $start_date }} to {{ $end_date }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Customer Orders Over Time</h5>
                                <canvas id="customerOrderChart"></canvas>
                            </div>
                            <div class="col-md-6">
                                <h5>Purchase Orders Over Time</h5>
                                <canvas id="purchaseOrderChart"></canvas>
                            </div>
                        </div>
                        <br><br>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Customer Expenses</h5>
                                <canvas id="customerExpenseChart"></canvas>
                            </div>
                            <div class="col-md-6">
                                <h5>Customer Order Status Distribution</h5>
                                <canvas id="polarAreaChart"></canvas>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                // Polar Area Chart
                                var ctx = document.getElementById('polarAreaChart').getContext('2d');
                                var polarAreaChart = new Chart(ctx, {
                                    type: 'polarArea',
                                    data: {
                                        labels: {!! json_encode($chartData['labels']) !!},
                                        datasets: [{
                                            label: 'Order Status Count',
                                            data: {!! json_encode($chartData['data']) !!},
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            r: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });

                                // Customer Orders Chart
                                var ctx1 = document.getElementById('customerOrderChart').getContext('2d');
                                var customerOrderChart = new Chart(ctx1, {
                                    type: 'line',
                                    data: {
                                        labels: @json($customerOrderSummary->keys()),
                                        datasets: [{
                                            label: 'Customer Orders',
                                            data: @json($customerOrderSummary->values()),
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            borderWidth: 1,
                                            fill: false
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });

                                // Purchase Orders Chart
                                var ctx2 = document.getElementById('purchaseOrderChart').getContext('2d');
                                var purchaseOrderChart = new Chart(ctx2, {
                                    type: 'line',
                                    data: {
                                        labels: @json($purchaseOrderSummary->keys()),
                                        datasets: [{
                                            label: 'Purchase Orders',
                                            data: @json($purchaseOrderSummary->values()),
                                            borderColor: 'rgba(153, 102, 255, 1)',
                                            borderWidth: 1,
                                            fill: false
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });

                                // Customer Expenses Chart
                                var ctx3 = document.getElementById('customerExpenseChart').getContext('2d');
                                var customerExpenseChart = new Chart(ctx3, {
                                    type: 'bar',
                                    data: {
                                        labels: @json($customerExpenses->keys()),
                                        datasets: [{
                                            label: 'Customer Expenses',
                                            data: @json($customerExpenses->values()),
                                            backgroundColor: 'rgba(255, 206, 86, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Customer Orders Chart
            var ctx = document.getElementById('customerOrderChart').getContext('2d');
            var customerOrderChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($customerOrderSummary->keys()),
                    datasets: [{
                        label: 'Customer Orders',
                        data: @json($customerOrderSummary->values()),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Purchase Orders Chart
            var ctx2 = document.getElementById('purchaseOrderChart').getContext('2d');
            var purchaseOrderChart = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: @json($purchaseOrderSummary->keys()),
                    datasets: [{
                        label: 'Purchase Orders',
                        data: @json($purchaseOrderSummary->values()),
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Customer Expenses Chart
            var ctx3 = document.getElementById('customerExpenseChart').getContext('2d');
            var customerExpenseChart = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: @json($customerExpenses->keys()),
                    datasets: [{
                        label: 'Customer Expenses',
                        data: @json($customerExpenses->values()),
                        backgroundColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
