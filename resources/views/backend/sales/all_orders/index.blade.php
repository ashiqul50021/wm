
@extends('admin.admin_master')
@section('admin')
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
                <h2 class="content-title card-title">All Order List</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <!-- card-header end// -->
                    <div class="card-body">
                        <form class="" action="" method="GET">
                            <div class="form-group row mb-3">
                                <div class="col-md-2">
                                    <label class="col-form-label"><span>All Orders :</span></label>
                                </div>
                            </div>
                            <div class="table-responsive-sm">
                                <table id='example' class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Invoice No</th>
                                            <th>Customer name</th>
                                            <th>Staff name</th>
                                            <th>Amount</th>
                                            <th>Discount Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Due Amount</th>
                                            <th>Delivery Status</th>
                                            <th>Payment Status</th>
                                            <th class="text-end">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($orders)
                                        @foreach ($orders as $key => $order)
                                                <tr>
                                                    {{-- <td>{{ $order->invoice_no }}</td>
                                                    <td><b>
                                                            @if ($order->user->role == 4)
                                                                Walk-in Customer
                                                            @else
                                                                {{ $order->user->name ?? 'Walk-in Customer' }}
                                                            @endif
                                                        </b></td>
                                                    <td>{{ $order->user->name ?? 'Admin' }}</td>
                                                    <td>

                                                        {{ $order->total ?? 0 }}
                                                    </td>
                                                    <td>

                                                        {{ $order->discount ?? 0 }}
                                                    </td>
                                                    <td>

                                                        {{ $order->paid ?? 0 }}
                                                    </td>
                                                    <td>

                                                        {{ $order->due ?? 0 }}
                                                    </td> --}}

                                                    <td>{{ $order->invoice_no }}</td>
                                                    <td><b>
                                                            @if ($order->user->role == 4)
                                                                Walk-in Customer
                                                            @else
                                                                {{ $order->user->name ?? 'Walk-in Customer' }}
                                                            @endif
                                                        </b></td>
                                                    <td>{{ $order->staff->user->name ?? 'Admin' }}</td>
                                                    <td>{{ $order->sub_total }}</td>
                                                    <td>{{ $order->discount }}</td>
                                                    <td>{{ $order->paid_amount }}</td>
                                                    <td>{{ $order->due_amount }}</td>

                                                    {{-- <td>
                                                        @if ($order->due == 0)
                                                            <span class="badge rounded-pill alert-success">Paid</span>
                                                        @elseif($order->due > 0 || $order->due < $order->total)
                                                            <span class="badge rounded-pill alert-warning">partial
                                                                paid</span>
                                                        @else
                                                            <span class="badge rounded-pill alert-danger">Un-Paid</span>
                                                        @endif
                                                    </td> --}}
                                                    <td>
                                                        @php
                                                            $status = $order->delivery_status;
                                                            if ($order->delivery_status == 'cancelled') {
                                                                $status = '<span class="badge rounded-pill alert-success">Received</span>';
                                                            }

                                                        @endphp
                                                        {!! $status !!}
                                                    </td>
                                                    <td>
                                                        @if ($order->payment_status == '1')
                                                            <span class="badge rounded-pill alert-success">Paid</span>
                                                        @else
                                                            <span class="badge rounded-pill alert-danger">Un-Paid</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                    <a class="btn btn-primary btn-icon btn-circle btn-sm btn-xs"
                                                        href="{{ route('all_orders.show', $order->id) }}">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-primary btn-icon btn-circle btn-sm btn-xs"
                                                        href="{{ route('invoice.download', $order->id) }}">
                                                        <i class="fa-solid fa-download"></i>
                                                    </a>
                                                    <a href="{{ route('delete.orders', $order->id) }}" id="delete"
                                                        class="btn btn-primary btn-icon btn-circle btn-sm btn-xs"
                                                        data-href="#">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <td>no order found</td>
                                        @endif

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
    @endpush
@endsection
