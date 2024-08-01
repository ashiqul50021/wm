
{{-- new format    --}}
@extends('admin.admin_master')
@section('admin')
    @push('css')
        <style>
            .invoice_image {
                width: 100px;
            }

            .invoice_customer_name p {
                color: #000;
                margin-bottom: 10px;
                font-size: 16px;
            }

            .invoice_main {
                position: relative;
                z-index: 1;
            }

            .select2-area {
                height: 42px !important;
                padding: 5px 15px !important;
            }

            .invoice_ttile strong {
                font-size: 24px;
                color: #3BB77E;
            }


            .invoice_customer_name {
                font-size: 18px;
                color: #3BB77E;
                font-weight: 500;
                line-height: 22px;
            }

            .invoice_innfo_list {
                margin-bottom: 3px;
                font-size: 14px;
                font-weight: 400;
            }

            .table thead th,
            .table tbody td {
                padding: 8px 25px;
            }

            .table thead th {
                color: #fff;
                background-color: #3BB77E;
            }


            .table-striped>tbody>tr:nth-of-type(odd)>* {
                --bs-table-accent-bg: transform;
                color: var(--bs-table-striped-color);
            }

            .table-striped>tbody>tr:nth-of-type(even)>* {
                --bs-table-accent-bg: var(--bs-table-striped-bg);
                color: var(--bs-table-striped-color);
            }

            .table> :not(caption)>*>* {
                padding: 8px 25px;
            }

            .invoice_block_title {
                font-size: 16px;
                color: #3BB77E;
                font-weight: 500;
            }

            .invoice_block_text {
                color: #63696f;
                font-size: 14px;
            }

            .payment_info_title {
                font-weight: 500;
                min-width: 120px;
                display: inline-block;
                font-size: 14px;
            }

            .invoice_payment {
                background: rgba(0, 0, 0, 0.05);
                max-width: 300px;
                width: 100%;
                padding: 10px;
            }

            .payment_info_list ul li span {
                font-size: 14px;
            }

            .invoice_payment ul li {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 5px 10px;
            }

            .invoice_payment ul li:not(:last-child) {
                margin-bottom: 4px;
            }


            .invoice_payment ul li:last-child {
                background: #3BB77E;
                color: #fff;
            }

            .btn_text a {
                font-size: 14px;
            }
        </style>
    @endpush
    <div class="card invoice_main">
        <div class="card-body">
            <div class="container" id="containerID">
                <div class="mb-5 mt-3">
                    <div class="invoice_top mb-5">
                        <div class="row justify-content-between">
                            <div class="col-sm-6">
                                <div class="invoice_image">
                                    @php
                                        $logo = get_setting('site_footer_logo');
                                    @endphp
                                    @if ($logo != null)
                                        <img style="font-size: 1.8rem; display: flex; height:60px; margin: 0 auto;"
                                            src="{{ asset(get_setting('site_footer_logo')->value ?? ' ') }}"
                                            alt="{{ env('APP_NAME') }}">
                                    @else
                                        <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}">
                                    @endif

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end invoice_ttile">
                                    <strong class="fa-4x ms-0">All Orders Invoice</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row gy-3 justify-content-between mb-5 align-items-end">
                        <div class="col-md-4">
                            <ul class="list-unstyled">
                                <li class="invoice_customer_name">
                                    Invoice to:
                                    <p>{{ $order->user->name ?? 'N/A' }}</p>
                                </li>
                                <li class="invoice_innfo_list">{{ $order->address ?? 'N/A' }}</li>
                                <li class="invoice_innfo_list">{{ $order->user->email ?? 'N/A' }}</li>
                                <li class="invoice_innfo_list">Phone: {{ $order->user->phone ?? 'N/A' }}</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="text-md-center invoice_ttile invoice_ttile_middle">
                                <strong class="fa-4x ms-0">Invoice</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <ul class="list-unstyled text-md-end">
                                <li class="">
                                    <span class="fw-bold me-2 d-inline-block">ID:</span>{{ $order->invoice_no ?? 'N/A' }}
                                </li>
                                <li class="">
                                    <span class="fw-bold me-2 d-inline-block">Creation Date:
                                    </span>{{ date('d-m-Y', strtotime($order->created_at)) }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row my-5 mx-1 justify-content-center table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead class="text-white">
                                <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Product Price</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Product Discount</th>
                                    <th scope="col">Shipping Charge</th>
                                    <th scope="col">Amount</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->order_details as $key => $item)
                                    <tr class="text-center">
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $item->product_name ?? 'N/A' }}</td>
                                        <td>{{ $item->price ?? 'N/A' }}</td>
                                        <td>{{ $item->qty ?? 'N/A' }}</td>
                                        <td>{{ $item->discount_1 ?? 'N/A' }}</td>
                                        <td>{{ $order->shipping_charge ?? 'N/A' }}</td>
                                        <td>{{ $order->grand_total ?? 'N/A' }}</td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="row gy3">
                        <div class="col-md-6">
                            <p class="ms-3 invoice_block_title">Description</p>
                            <p class="ms-3 invoice_block_text">{{ $order->discription ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <div class="invoice_payment ms-md-auto">
                                <ul class="list-unstyled text-md-end">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <strong class="me-4">SubTotal</strong>
                                            </td>
                                            <td>
                                                {{ $order->sub_total ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="me-4">Total Product discount</strong>
                                            </td>
                                            <td>
                                                {{ $order->discount ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="me-4">Additional discount</strong>
                                            </td>
                                            <td>
                                                {{ $order->additional_discount ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="me-4">overall discount</strong>
                                            </td>
                                            <td>
                                                {{ $order->overall_discount ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="me-4">Paid</strong>
                                            </td>
                                            <td>
                                                {{ $order->paid ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="me-4">Due</strong>
                                            </td>
                                            <td>
                                                {{ $order->due_amount ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="me-4">Grand Total</strong>
                                            </td>
                                            <td>
                                                {{ $order->grand_total ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </table>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div class="row my-5">
                        <div class="col-md-6">
                            <p class="invoice_block_title text-black ms-3">
                                Thank you for your purchase
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="invoice_block_title text-black text-md-end d-inline-block border-top">
                                Singature
                            </p>
                        </div>
                    </div>
                    <div class="text-center btn_text" id="btn_wrapper">
                        <a class="btn btn-light text-capitalize border-0" id="print" target="_blank"
                            href="{{ route('orderPrints', $order->id) }}" data-mdb-ripple-color="dark"><i
                                class="fas fa-print text-primary"></i> Print</a>
                        <a href="" class="btn btn-light text-capitalize"
                            data-mdb-ripple-color="dark">
                            Back To All Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

