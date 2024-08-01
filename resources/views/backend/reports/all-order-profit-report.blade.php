@extends('admin.admin_master')
@section('admin')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style type="text/css">
        table,
        tbody,
        tfoot,
        thead,
        tr,
        th,
        td {
            border: 1px solid #dee2e6 !important;
        }

        th {
            font-weight: bolder !important;
        }
    </style>

    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">All Order Profit Report</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <!-- card-header end// -->
                    <div class="card-body">


                        <form action="{{ route('all.order.profit.report') }}" method="get" class="mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="start_date">Start Date:</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date">End Date:</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control">
                                </div>
                                <div class="col-md-2 mt-4">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>

                        {{-- @if (count($profitData) == 0)
                            <h3 class="text-center mt-5">No Order Found</h3>
                        @else --}}
                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Order ID</th>
                                    <th>Product Name</th>
                                    <th>(Purchase Price x quantity)</th>
                                    <th>(Selling Price x quantity)</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPurchasePrice = 0;
                                    $totalSellingPrice = 0;
                                    $totalProfit = 0;
                                @endphp
                                @foreach ($profitData as $order)
                                    @php
                                        $orderProfit = 0;
                                    @endphp
                                    @foreach ($order->order_Details as $orderDetail)
                                        @php
                                            $product = $orderDetail->product;
                                            $purchasePrice = ($product->purchase_price) * ($orderDetail->qty);
                                            $sellingPrice = ($orderDetail->price) * ($orderDetail->qty);
                                            $profit = ($sellingPrice - $purchasePrice);
                                            $orderProfit += $profit;
                                            $totalPurchasePrice += $purchasePrice;
                                            $totalSellingPrice += $sellingPrice;
                                        @endphp
                                        <tr>
                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $orderDetail->product->name_en }}</td>
                                            <td>{{ $purchasePrice }}</td>
                                            <td>{{ $sellingPrice }}</td>
                                            <td>{{ $profit }}</td>
                                        </tr>
                                    @endforeach
                                    @php
                                        $totalProfit += $orderProfit;
                                        // $totalProfit = $sellingPrice - $purchasePrice;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="3">Total</td>
                                    <td>Total Purchase Price: {{ $totalPurchasePrice }}</td>
                                    <td>Total Selling Price: {{ $totalSellingPrice }}</td>
                                    <td>Total Profit: {{ $totalProfit }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <!-- card-body end// -->
                </div>
                <!-- card end// -->
            </div>

        </div>
    </section>

    @push('footer-script')
        <script>
            $(document).ready(function() {
                $('#reportrange').daterangepicker({
                    locale: {
                        format: 'DD-MM-Y'
                    },
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'This Year': [moment().startOf('year'), moment().endOf('year')]
                    }
                });
            });
        </script>
    @endpush
@endsection
