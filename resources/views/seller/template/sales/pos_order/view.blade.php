@extends('vendor.vendor_master')
@section('vendor')
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
                <h2 class="content-title card-title">Pos Order show</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <!-- card-header end// -->
                    <div class="card-body">
                        <div class="row mb-50 mt-20 order-info-wrap">
                            <div class="col-md-4">
                                <article class="icontext align-items-start">
                                    <span class="icon icon-sm rounded-circle bg-primary-light">
                                        <i class="text-primary material-icons md-person"></i>
                                    </span>

                                    <div class="text">
                                        <h6 class="mb-1">Customer</h6>
                                        <p class="mb-1">
                                            {{ $posorder->user->name ?? 'null' }} <br />
                                            {{ $posorder->user->email ?? 'null' }} <br />
                                            {{ $posorder->user->phone ?? 'null' }}
                                        </p>
                                        {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop1{{ $order->id }}">Edit Customer</a> --}}
                                    </div>
                                </article>
                            </div>
                            <!-- col// -->

                            <!-- col// -->
                            {{-- <div class="col-md-4">
                                <article class="icontext align-items-start">
                                    <span class="icon icon-sm rounded-circle bg-primary-light">
                                        <i class="text-primary material-icons md-place"></i>
                                    </span>
                                    <div class="text">
                                        <h6 class="mb-1">Deliver to</h6>
                                        <p class="mb-1">
                                            City: {{ ucwords($order->upazilla->name_en ?? '' ) }}, <br />{{ ucwords($order->district->district_name_en ?? '') }},<br />
                                            {{ ucwords($order->division->division_name_en ?? '') }}
                                        </p>



                                    </div>
                                </article>
                            </div> --}}
                            <!-- col// -->
                            <div class="col-md-12 mt-40">
                                <table class="table table-bordered">
                                    {{-- <form action="{{ route('admin.orders.update',$order->id) }}" method="post"> --}}
                                    @csrf
                                    <tbody>
                                        <tr>
                                            <th>Invoice</th>
                                            <td>{{ $posorder->invoice_no ?? '' }}</td>

                                        </tr>
                                        <tr>
                                            <th>Sale By</th>
                                            <td><input type="" class="form-control" name="email" readonly
                                                    value="{{ $posorder->saleby->name ?? 'Null' }}"></td>
                                        </tr>
                                        <tr>
                                            <th>Discount</th>
                                            <td><input type="" class="form-control" name="discount" readonly
                                                    value="{{ $posorder->discount ?? '' }}"></td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td>{{ date_format($posorder->created_at ?? '', 'Y/m/d') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            {{-- <td>{{ date_format($order->created_at ?? '',"Y/m/d")}}</td> --}}
                                            <td>{{ $posorder->discription ?? '' }}</td>
                                        </tr>




                                    </tbody>
                                </table>
                            </div>
                            <!-- col// -->
                        </div>
                        <!-- row // -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive-sm">
                                    <table id="example" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th  scope="col">Product Image</th>
                                                <th  scope="col">Product Name</th>
                                                <th scope="col">Unit Price</th>
                                                <th  scope="col">Quantity</th>
                                                <th width="10%">Discount</th>

                                                <th width="20%">Total Price</th>


                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($posorder->vendorPosOrderItem as $key => $orderDetail)
                                                <tr>
                                                    <td>
                                                        <a class="itemside" href="#">
                                                            <div class="left">
                                                                <img src="{{ asset($orderDetail->product_image ?? ' ') }}"
                                                                    width="40" height="40" class="img-xs"
                                                                    alt="Item" />
                                                            </div>
                                                            <div class="info">
                                                                <span class="text-bold">
                                                                    {{ $orderDetail->product_name ?? 'No Name' }}
                                                                </span>


                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td> {{ $orderDetail->product_name ?? 'No Name' }}</td>
                                                    <td>{{ $orderDetail->product_price ?? '0.00' }}</td>
                                                    <td>{{ $orderDetail->qty ?? '0' }}</td>
                                                    <td>{{ $orderDetail->product_discount ?? '0' }}</td>
                                                    <td class="text-end">{{ $orderDetail->product_total_price ?? '0.00' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="6">
                                                    <article class="float-end">
                                                        <dl class="dlist">
                                                            <dt>Total:</dt>
                                                            <dd>{{ $posorder->total ?? '0.00' }}</dd>
                                                        </dl>
                                                        <dl class="dlist">
                                                            <dt>Paid:</dt>
                                                            <dd>{{ $posorder->paid ?? '' }}</dd>
                                                        </dl>
                                                        <dl class="dlist">
                                                            <dt>Due:</dt>
                                                            <dd><b class="">{{ $posorder->paid ?? '' }}</b></dd>
                                                        </dl>


                                                    </article>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- table-responsive// -->
                            </div>

                            <!-- col// -->

                        </div>


                    </div>
                    <!-- card-body end// -->
                </div>
                <!-- card end// -->
            </div>
        </div>
    </section>

    @push('footer-script')
        <script type="text/javascript"></script>
    @endpush
@endsection
