@extends('vendor.vendor_master')
@section('vendor')
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
                        <form class="" action="{{ route('vendor.posSaleReport') }}" method="GET">
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
                                            <th>Date</th>
                                            <th>Customer name</th>
                                            <th>Staff name</th>
                                            <th>Amount</th>
                                            <th>Discount Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Due Amount</th>
                                            <th>Payment Status</th>
                                            <th>Total Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($posOrder)
                                        @foreach ($posOrder as $key => $order)
                                            <tr>
                                                <td>{{ $order->invoice_no ?? 'N/A' }}</td>
                                                <td>{{ $order->created_at }}</td>
                                                <td><b>
                                                    @if ($order->user == null || $order->user->role == 4)

                                                            Walk-in Customer
                                                        @else
                                                            {{ $order->user->name ?? 'Walk-in Customer' }}
                                                        @endif
                                                    </b></td>
                                                <td>{{ $order->user->name ?? 'Admin' }}</td>
                                                <td>

                                                    {{ $order->subtotal ?? 0 }}
                                                </td>
                                                <td>

                                                    {{ $order->discount ?? 0 }}
                                                </td>
                                                <td>

                                                    {{ $order->paid ?? 0 }}
                                                </td>
                                                <td>

                                                    {{ $order->due ?? 0 }}
                                                </td>



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
                                                <td>

                                                    {{ $order->paid ?? 0 }}
                                                </td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <td>no order found</td>
                                        @endif

                                    </tbody>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><strong>Total Amount : </strong></td>
                                        <td>Total = {{ number_format($posOrder->sum('subtotal') ?? 0, 2) }}</td>
                                        <td>Discount = {{ number_format($posOrder->sum('discount') ?? 0, 2) }}</td>
                                        <td>Paid = {{ number_format($posOrder->sum('paid') ?? 0, 2) }}</td>
                                        <td>Due = {{ number_format($posOrder->sum('due') ?? 0, 2) }}</td>
                                        <td></td>
                                        <td>Total Amount = {{ number_format($posOrder->sum('total') ?? 0, 2) }}</td>
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
