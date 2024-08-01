@extends('admin.admin_master')
@section('admin')

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
            <h2 class="content-title card-title">Order detail</h2>
            <p>Details for Order ID: {{ $order->invoice_no?? ''}}</p>
        </div>
    </div>
    <div class="card">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-4 mb-lg-0 mb-15">
                    <span class="text-white"> <i class="material-icons md-calendar_today"></i> <b>{{ $order->created_at?? ''}}</b> </span> <br />
                    <small class="text-white">Order ID: {{ $order->invoice_no?? ''}}</small>
                </div>
                @php
                    $delivery_status = $order->delivery_status;
                @endphp
                <div class="col-lg-8 col-md-8 ms-auto text-md-end">
                    {{-- <select class="form-select d-inline-block mb-lg-0 mr-5 mw-200" id="update_payment_status">
                        <option value="0" @if ($payment_status == '0') selected @endif>Unpaid</option>
                        <option value="1" @if ($payment_status == '1') selected @endif>Paid</option>
                    </select> --}}
                    @if($delivery_status != 'delivered' && $delivery_status != 'cancelled')
                    <select class="form-select d-inline-block mb-lg-0 mr-5 mw-200" id="update_delivery_status">
                        <option value="pending" @if ($delivery_status == 'pending') selected @endif>Pending</option>
                        <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>Confirmed</option>
                        <option value="shipped" @if ($delivery_status == 'shipped') selected @endif>Shipped</option>
                        <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>Picked Up</option>
                        <option value="on_the_way" @if ($delivery_status =='on_the_way') selected @endif>On The Way</option>
                        <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>Delivered</option>
                        <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>Cancel</option>
                    </select>
                    @else
                        <input type="text" class="form-control d-inline-block mb-lg-0 mr-5 mw-200" value="{{ $delivery_status }}" disabled>
                    @endif

                    <!-- <a class="btn btn-primary" href="#">Save</a> -->
                    <!-- <a class="btn btn-secondary print ms-2" href="#" onclick="window.print();"><i class="icon material-icons md-print"></i></a> -->
                </div>
            </div>
        </header>
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
                                {{ $order->user->name ?? ''}} <br />
                                {{ $order->user->email ?? ''}} <br />
                                {{ $order->user->phone ?? ''}}
                            </p>
                            {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop1{{ $order->id }}">Edit Customer</a> --}}
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
                            <h6 class="mb-1">Order info</h6>
                            <p class="mb-1">
                                Order Id: {{ $order->invoice_no?? ''}} </br>
                                Shipping: {{$order->shipping_name ?? ''}} <br />
                                Pay method: @if($order->payment_method == 'cod') Cash On Delivery @else {{ $order->payment_method ?? 'payment method'}} @endif <br />
                                Status: @php
                                            $status = $order->delivery_status;
                                            if($order->delivery_status == 'cancelled') {
                                                $status = 'Received';
                                            }

                                        @endphp
                                        {!! $status !!}
                            </p>
                            {{-- <a href="#">Download info</a> --}}
                        </div>
                    </article>
                </div>
                <!-- col// -->
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-place"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Deliver to</h6>
                            <p class="mb-1">
                                <Address>
                                    {{$order->user->address}}
                                </Address>
                                {{-- City: {{ ucwords($order->upazilla->name_en ?? '' ) }}, <br />{{ ucwords($order->district->district_name_en ?? '') }},<br />
                                {{ ucwords($order->division->division_name_en ?? '') }} --}}
                            </p>
                        </div>
                    </article>
                </div>
                <!-- col// -->
                <div class="col-md-12 mt-40">
                    <table class="table table-bordered">
                        <form action="{{ route('admin.orders.update',$order->id) }}" method="post">
                            @csrf
                            <tbody>
                                <tr>
                                    <th>Invoice</th>
                                    <td>{{ $order->invoice_no?? ''}}</td>
                                    <th>Email</th>
                                    <td><input type="" class="form-control" name="email" value="{{ $order->user->email ?? 'Null'}}"></td>
                                </tr>

                                <tr>

                                    <th>Payment Date</th>
                                    <td>{{ date_format($order->created_at,"Y/m/d")}}</td>
                                </tr>
                                <tr>
                                    {{-- <th>Sub Total</th>
                                    <td>{{ $order->sub_total }} <strong>Tk</strong></td> --}}

                                    <th>Total Amount</th>
                                    <td>{{ $order->total_amount ?? '' }} <strong>Tk</strong></td>
                                    <th>Confirm Amount</th>
                                    <td>{{ $order->confirm_amount ?? '' }} <strong>Tk</strong></td>
                                    <th>Pending Amount</th>
                                    <td>{{ $order->pending_amount ?? '' }} <strong>Tk</strong></td>
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
                                    <th>Product Image</th>

                                    <th>Product</th>

                                    <th >Unit Price</th>
                                    <th >Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->requestConfirmProduct as $key => $dealer_request_product)

                                    <tr>
                                        <td>
                                            <a class="itemside" href="#">
                                                <div class="left">

                                                        <img src="{{ asset($dealer_request_product->product->product_thumbnail ?? ' ') }}" width="40" height="40" class="img-xs" alt="Item">

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

                                        <td>{{ $dealer_request_product->unit_price ?? '0.00' }}</td>
                                        <td>{{ $dealer_request_product->confirm_qty ?? '0' }}</td>
                                        <td>{{ $dealer_request_product->total_price ?? '0.00' }}</td>
                                        @php
                                                $manufacture = \App\Models\Manufacture::where(
                                                    'dealer_confirm_id',
                                                    $order->id,
                                                )
                                                    ->where('product_id', $dealer_request_product->product_id)
                                                    ->where('is_dealer_manufacture', 1)
                                                    ->first();
                                            @endphp

                                            <td>
                                                @if (!$manufacture)
                                                    <button type="button" class="btn btn-primary dealerManufacture"
                                                        product_id="{{ $dealer_request_product->product_id }}"
                                                        data_qty="{{ $dealer_request_product->confirm_qty }}">Manufac.
                                                        order</button>
                                                @endif

                                            </td>
                                    </tr>
                                    <input type="hidden" name="dealer_request_id" value="{{$dealer_request_product->dealer_request_id}}">
                                @endforeach
                                <tr>
                                    <td colspan="4">
                                        <article class="float-end">


                                            <dl class="dlist">
                                                <dt>Confirm Total:</dt>
                                                <dd><b class="">{{ $order->confirm_amount ?? '' }}</b></dd>
                                            </dl>
                                            <dl class="dlist">
                                                <dt>Pending Total:</dt>
                                                <dd><b class="">{{ $order->pending_amount ?? '' }}</b></dd>
                                            </dl>
                                            <dl class="dlist">
                                                <dt>Grand total:</dt>
                                                <dd><b class="h5">{{ $order->total_amount ?? '' }}</b></dd>
                                            </dl>
                                            <dl class="dlist">
                                                <dt class="text-muted">Status:</dt>
                                                <dd>
                                                    @php
                                                        $status = $order->delivery_status;
                                                        if($order->delivery_status == 'cancelled') {
                                                            $status = 'Received';
                                                        }

                                                    @endphp
                                                    <span class="badge rounded-pill alert-success text-success">{!! $status !!}</span>
                                                </dd>
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
                <div class="col-lg-1"></div>
                {{-- <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Order</button>
                </div> --}}
                <!-- col// -->
            </form>
            </div>
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
    
    
    
        {{-- modal for dealer manufacture --}}
        <div id="dealerManufactureModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Body Part Order</h4>
                    </div>
                    <div class="modal-body">
                        <form id="modalForm" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <img src="" id="dealerthumbnailImage" alt="" width="200"
                                    height="200">
                                <img src="" id="dealermanufactureImage" alt="" width="200"
                                    height="200">
                            </div>
                            <div class="form-group mt-2">
                                <p>Product Name : <span id="dealerproductNameText"></span></p>
                                <input type="hidden" class="form-control" name="product_id" id="productName"
                                    value="">
                            </div>
                            <div class="form-group">
                                <label for="manufacturePart" class="control-label">Manufacture Part:</label>
                                <input type="text" class="form-control" readonly name="manufacture_part"
                                    id="manufacturePart" value="body-part">
                            </div>
                            <div class="form-group mt-5">

                                <label for="workerAll" class="control-label">Select Worker</label>
                                <select name="user_id" id="workerAll" class="form-select">

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="manufacturePart" class="control-label">Manufacture Price:</label>
                                <input type="text" class="form-control" name="manufacture_price"
                                    id="manufacturePrice" readonly>
                            </div>
                            <div class="form-group">
                                <label for="manufacturePart" class="control-label">Manufacture Quantity:</label>
                                <input type="text" class="form-control" name="manufacture_quantity"
                                    id="manufactureQuantity" value="">
                            </div>
                            <div class="form-group">
                                <label for="manufacturePart" class="control-label">Total Price:</label>
                                <input type="text" class="form-control" readonly name="total_price" id="totalPrice">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label">Message:</label>
                                <textarea class="form-control" name="note" id="message-text"></textarea>
                            </div>
                            <div class="custom-control custom-switch mb-2">
                                <input type="checkbox" class="form-check-input me-2 cursor" name="is_confirm"
                                    id="is_confirm" value="1">
                                <label class="form-check-label cursor" for="is_confirm">Is Confirm</label>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default close" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>

                            <input type="hidden" name="customer_name" value="{{ $order->user->name ?? 'N/A' }}">
                            <input type="hidden" name="is_dealer_manufacture" value='1'>
                            <input type="hidden" name="dealer_confirm_id" value="{{ $order->id }}">
                        </form>
                    </div>

                </div>
            </div>
        </div>

</section>
@endsection
@push('footer-script')

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="shipping_id"]').on('change', function(){
            var shipping_cost = $(this).val();
            if(shipping_cost) {
                $.ajax({
                    url: "{{  url('/checkout/shipping/ajax') }}/"+shipping_cost,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                        //console.log(data);
                        $('#ship_amount').text(data.shipping_charge);

                        let shipping_price = parseInt(data.shipping_charge);
                        let grand_total_price = parseInt($('#cartSubTotalShi').val());
                        grand_total_price += shipping_price;
                        $('#grand_total_set').html(grand_total_price);
                        $('#total_amount').val(grand_total_price);
                    },
                });
            } else {
                alert('danger');
            }
        });
    });

    /* ============ Update Payment Status =========== */
    $('#update_payment_status').on('change', function(){
        var order_id = {{ $order->id }};
        var status = $('#update_payment_status').val();
        $.post('{{ route('orders.update_payment_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
            // console.log(data);
            // Start Message
            const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',

                  showConfirmButton: false,
                  timer: 1000
                })
            if ($.isEmptyObject(data.error)) {
                Toast.fire({
                    type: 'success',
                    icon: 'success',
                    title: data.success
                })
            }else{
                Toast.fire({
                    type: 'error',
                    icon: 'error',
                    title: data.error
                })
            }
            // End Message
        });
    });

    /* ============ Update Delivery Status =========== */
    $('#update_delivery_status').on('change', function(){
        var order_id = {{ $order->id }};
        var status = $('#update_delivery_status').val();
        $.post('{{ route('orders.update_delivery_status') }}', {
            _token:'{{ @csrf_token() }}',
            order_id:order_id,
            status:status
        }, function(data){
            // console.log(data);
            // Start Message
            const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',

                  showConfirmButton: false,
                  timer: 1000
                })
            if ($.isEmptyObject(data.error)) {
                Toast.fire({
                    type: 'success',
                    icon: 'success',
                    title: data.success
                })
            }else{
                Toast.fire({
                    type: 'error',
                    icon: 'error',
                    title: data.error
                })
            }
            // End Message
        });
    });
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!--  Division To District Show Ajax -->
<script type="text/javascript">
  $(document).ready(function() {
    $('select[name="division_id"]').on('change', function(){
        var division_id = $(this).val();
        // const divArray = division.split("-");
        // var division_id = divArray[0];
        // $('#division_name').val(divArray[1]);
        if(division_id) {
            $.ajax({
                url: "{{  url('/division-district/ajax') }}/"+division_id,
                type:"GET",
                dataType:"json",
                success:function(data) {
                    $('select[name="district_id"]').html('<option value="" selected="" disabled="">Select District</option>');
                      $.each(data, function(key, value){
                        // console.log(value);
                          $('select[name="district_id"]').append('<option value="'+ value.id +'">' + capitalizeFirstLetter(value.district_name_en) + '</option>');
                    });
                    $('select[name="upazilla_id"]').html('<option value="" selected="" disabled="">Select District</option>');
                },
            });
        } else {
           alert('danger');
        }
    });
    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
});
</script>

<!--  District To Upazilla Show Ajax -->
<script type="text/javascript">
  $(document).ready(function() {
    $('select[name="district_id"]').on('change', function(){
        var district_id = $(this).val();
        // const divArray = district.split("-");
        // var division_id = divArray[0];
        // $('#district_name').val(divArray[1]);
        if(district_id) {
            $.ajax({
                url: "{{  url('/district-upazilla/ajax') }}/"+district_id,
                type:"GET",
                dataType:"json",
                success:function(data) {
                   var d =$('select[name="upazilla_id"]').empty();
                      $.each(data, function(key, value){
                          $('select[name="upazilla_id"]').append('<option value="'+ value.id +'">' + value.name_en + '</option>');
                          $('select[name="upazilla_id"]').append('<option  class="d-none" value="'+ value.id +'">' + value.name_en + '</option>');
                      });
                },
            });
        } else {
            alert('danger');
        }
    });
});
</script>


 <script type="text/javascript">
        // dealer manufacture
        $(document).on("click", ".dealerManufacture", function() {
            var productId = $(this).attr('product_id');
            var quantity = $(this).attr('data_qty');
            var url = "{{ route('getDealerManufacture') }}";
            console.log("product id", productId, quantity, url)
            $('#dealerManufactureModal').modal('show');
            var manufacturePart = $("#manufacturePart").val();
            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: {
                    product_id: productId,
                    quantity: quantity,
                    manufacture_part: manufacturePart,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log("success", data);
                    var dealerthumbnailImage = window.origin + '/' + data?.products?.product_thumbnail;
                    var dealermanufactureImage = window.origin + '/' + data?.products
                        ?.menu_facture_image;

                    $('#dealerthumbnailImage').attr('src', dealerthumbnailImage);
                    $('#dealermanufactureImage').attr('src', dealermanufactureImage);
                    $("#productName").val(data?.products?.id);
                    $("#dealerproductNameText").text(data?.products?.name_en);
                    $("#manufacturePrice").val(data?.products?.body_rate);
                    $("#manufactureQuantity").val(quantity);
                    var totalPrice = parseFloat(data?.products?.body_rate) * parseFloat(quantity);
                    $("#totalPrice").val(totalPrice);
                    console.log(totalPrice)

                    var allOptions = '';
                    for (var i = 0; i < data?.workers?.length; i++) {
                        var singleWorker = data?.workers[i];
                        var options =
                            `<option value="${singleWorker?.id}">${singleWorker?.name}</option>`;

                        allOptions += options;
                    }
                    console.log(allOptions)

                    $("#workerAll").html(allOptions)
                    var formAction = "{{ route('manufacture.store') }}";
                    console.log(formAction)


                    // $("#modalForm").attr()
                    $('#modalForm').attr('action', formAction);
                },
            })

        })


        // for modal close
        $(document).on("click", ".close", function() {
            $('#dealerManufactureModal').modal('hide');
        })


        $(document).on("keyup", "#manufactureQuantity", function() {
            var value = $(this).val();
            var ratePrice = $("#manufacturePrice").val();
            console.log("chnage quantity", value)
            var totalPrice = parseFloat(ratePrice ?? 0) * parseFloat(value ?? 0) ?? 0;
            $("#totalPrice").val(totalPrice);
            console.log(totalPrice)
        })
    </script>

@endpush