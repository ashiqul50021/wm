@extends('dealer.dealer_master')
@section('dealer')
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
            <div class="content-header">
                <h2 class="content-title">Order List <span class="badge rounded-pill alert-success"> {{ count($orders) }}
                    </span></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <!-- card-header end// -->
                    <div class="card-body">
                        <form class="" action="" method="GET">
                            <div class="table-responsive-sm">
                                <table id="example" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Invoice No.</th>
                                            <th>Dealer name</th>
                                            <th>Date</th>
                                            <th>Confirm Date</th>
                                            <th>Total Amount</th>
                                            <th>Confirm Amount</th>
                                            <th>Pending Amount</th>
                                            <th class="w-25">Note</th>
                                            <th>Delivery Status</th>

                                            <th class="text-end">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $order)
                                            {{-- @dd($order->delivery_status); --}}

                                            <tr>
                                                <td>{{ $order->invoice_no ?? '-' }}</td>
                                                <td><b>{{ $order->user->name ?? '' }}</b></td>
                                                <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($order->updated_at)) }}</td>
                                                <td>

                                                    {{ $order->total_amount ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $order->confirm_amount ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $order->pending_amount ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $order->note ?? '' }}
                                                </td>
                                                <td>
                                                    @php
                                                        $status = $order->delivery_status;
                                                        if ($order->delivery_status == 'cancelled') {
                                                            $status =
                                                                '<span class="badge rounded-pill alert-success">Received</span>';
                                                        }

                                                    @endphp
                                                    {!! $status !!}
                                                </td>
                                                {{-- <td>
                                    	@if ($order->payment_status == '1')
				                            <span class="badge rounded-pill alert-success">Paid</span>
				                            @else
				                            <span class="badge rounded-pill alert-danger">Un-Paid</span>
				                        @endif
                                    </td> --}}
                                                <td class="text-end">
                                                    <a class="btn btn-primary btn-icon btn-circle btn-sm btn-xs"
                                                        href="{{ route('dealer.order.show', $order->id) }}">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-primary btn-icon btn-circle btn-sm btn-xs"
                                                        href="{{ route('dealer.invoice.download', $order->id) }}">
                                                        <i class="fa-solid fa-download"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
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
        <script type="text/javascript">
            $(function() {

                $('input[name="date"]').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    }
                });

                $('input[name="date"]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                        'MM/DD/YYYY'));
                });

                // $('input[name="date"]').on('cancel.daterangepicker', function(ev, picker) {
                //     $(this).val('');
                // });

                var start = moment().subtract(29, 'days');
                var end = moment();

                // start = '';
                // end = '';

                $('input[name="date"]').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    }
                });

                function cb(start, end) {
                    $('#reportrange').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }

                $('#reportrange').daterangepicker({
                    startDate: start,
                    endDate: end,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    }
                }, cb);

                cb(start, end);

            });
        </script>
    @endpush
@endsection
