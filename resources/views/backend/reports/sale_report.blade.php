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
                <h2 class="content-title card-title">Pos Sale Report</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <!-- card-header end// -->
                    <div class="card-body">
                        <form class="" action="{{ route('searchBySaleReport') }}" method="GET">
                            <div class="form-group row mb-3 ">
                                <div class="col-md-6">
                                    <label class="col-form-label"><span>Pos Sale Orders :</span></label>
                                </div>

                                {{-- <div class="col-md-2 mt-2">

                                </div>
                                <div class="col-md-2 mt-2">

                                </div> --}}
                                <div class="col-md-3 mt-2">
                                    <div class="custom_select">
                                        <input type="text" id="reportrange" class="form-control" name="date"
                                            placeholder="Filter by date" data-format="DD-MM-Y" value="Filter by date"
                                            data-separator=" - " autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <button class="btn btn-primary" type="submit">Filter</button>
                                </div>
                            </div>
                            <div class="table-responsive-sm">
                                <table id='example' class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Invoice No.</th>
                                            <th>Customer name</th>
                                            <th>Staff name</th>
                                            <th>Price</th>
                                            <th>Overall Discount</th>
                                            <th>After Discount</th>

                                            <th>Due Amount</th>
                                            <th>Payment Status</th>
                                            <th>Total Paid Amount</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($posOrder)
                                            @foreach ($posOrder as $key => $order)
                                                <tr>
                                                    <td>{{ $order->invoice_no }}</td>
                                                    <td><b>
                                                            @if ($order->user->role == 4)
                                                                Walk-in Customer
                                                            @else
                                                                {{ $order->user->name ?? 'Walk-in Customer' }}
                                                            @endif
                                                        </b></td>
                                                    <td>{{ $order->user->name ?? 'Admin' }}</td>
                                                    <td>{{ $order->subtotal ?? 0 }}</td>
                                                    <td>{{ $order->overall_discount ?? 0 }}</td>

                                                    <td>{{ $order->paid ?? 0 }}</td>
                                                    <td>{{ $order->due ?? 0 }}</td>
                                                    <td>
                                                        @if ($order->due == 0)
                                                            <span class="badge rounded-pill alert-success">Paid</span>
                                                        @elseif($order->due > 0 || $order->due < $order->total)
                                                            <span class="badge rounded-pill alert-warning">partial
                                                                paid</span>
                                                        @else
                                                            <span class="badge rounded-pill alert-danger">Un-Paid</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $order->total ?? 0 }}</td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <td>no order found</td>
                                        @endif

                                    </tbody>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><strong>Total Amount:</strong></td>
                                        <td>Total= {{ number_format($posOrder->sum('subtotal') ?? 0, 2) }}</td>
                                        <td>Discount= {{ number_format($posOrder->sum('discount') ?? 0, 2) }}</td>
                                        <td>After Discount= {{ number_format($posOrder->sum('total') ?? 0, 2) }}</td>
                                        <td>Due= {{ number_format($posOrder->sum('due') ?? 0, 2) }}</td>
                                        <td></td>
                                        <td>Total Paid= {{ number_format($posOrder->sum('paid') ?? 0, 2) }}</td>

                                    </tr>
                                </table>


                            </div>
                        </form>
                        <!-- table-responsive //end -->
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
