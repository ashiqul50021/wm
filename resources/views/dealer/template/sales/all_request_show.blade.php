@extends('dealer.dealer_master')
@section('dealer')

<style type="text/css">
    table, tbody, tfoot, thead, tr, th, td{
        border: 1px solid #dee2e6 !important;
    }
    th{
        font-weight: bolder !important;
    }
</style>
<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Request Detail</h2>
        </div>
    </div>
    <div class="card">
        <!-- card-header end// -->
        <div class="card-body">
            <div class="row mb-50 mt-20 order-info-wrap">
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-person"></i>
                        </span>

                        <div class="text">
                            <h6 class="mb-1">Dealer</h6>
                            <p class="mb-1">
                                {{ $dealer->user->name ?? ''}} <br/>
                                {{ $dealer->user->email ?? ''}} <br/>
                                {{ $dealer->user->phone ?? ''}}
                            </p>
                        </div>
                    </article>
                </div>
                <!-- col// -->
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-local_shipping"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Request info</h6>
                            <p class="mb-1">
                                Status: {{ $dealer->delivery_status }}
                            </p>
                        </div>
                    </article>
                </div>
                <!-- col// -->
                <div class="col-md-12 mt-40">
                    <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Delivery Status</th>
                                    <td>
                                        <span class="badge rounded-pill alert-success text-success">{{$dealer->delivery_status}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Date</th>
                                    <td>{{ date_format($dealer->created_at,"Y/m/d")}}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount</th>
                                    <td>{{ $dealer->total_amount }} <strong>Tk</strong></td>
                                </tr>
                            </tbody>
                    </table>
                </div>
                <!-- col// -->
            </div>
            <!-- row // -->
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Invoice Numnber</th>
                                    <th>Product Image</th>
                                    <th>Product</th>
                                    <th >Unit Price</th>
                                    <th >Quantity</th>
                                    <th>Total</th>
                                    <th> Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dealer->dealer_request_products as $key => $dealer_request_product)
                                @if($dealer_request_product->is_varient == 1)
                                    @php
                                        $product_variant = App\Models\ProductStock::where('id',$dealer_request_product->product_stock_id)->first();
                                    @endphp
                                @endif
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ $dealer->invoice_no }}</td>
                                    <td>
                                        <a class="itemside" href="#">
                                            <div class="left">
                                                @if($dealer_request_product->is_varient == 0)
                                                <img src="{{ asset($dealer_request_product->product->product_thumbnail ?? ' ') }}" width="40" height="40" class="img-xs" alt="Item" />
                                                @else
                                                    <img src="{{ asset($product_variant->image ?? '') }}" width="40" height="40" class="img-xs" alt="Item" />
                                                @endif
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="itemside" href="#">
                                            <div class="info">
                                                <span class="text-bold">
                                                    {{$dealer_request_product->product->name_en ?? ' '}}
                                                </span>
                                            </div>
                                        </a>
                                    </td>

                                    <td>{{ $dealer_request_product->price ?? '0.00' }}</td>
                                    <td>{{ $dealer_request_product->qty ?? '0' }}</td>
                                    <td>{{ $dealer_request_product->price*$dealer_request_product->qty ?? '0.00' }}</td>
                                    <td>{{ $dealer_request_product->delivery_status }}</td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="7">
                                        <article class="float-end">
                                            <dl class="dlist">
                                                <dt>Total Amount:</dt>
                                                <dd><b class="h5">{{ $dealer->total_amount }}TK</b></dd>
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
</section>
@endsection
@push('footer-script')

@endpush
