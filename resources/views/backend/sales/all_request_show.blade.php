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
                <h2 class="content-title card-title">Request Detail</h2>
            </div>
        </div>
        <form action="{{ route('admin.dealer.order') }}" method="post">
            @csrf
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
                                        {{ $dealer->user->name ?? '' }} <br />
                                        {{ $dealer->user->email ?? '' }} <br />
                                        {{ $dealer->user->phone ?? '' }}
                                    </p>
                                </div>
                            </article>
                        </div>
                        <!-- col// -->
                        <div class="col-md-4">
                            <article class="icontext align-items-start">
                                {{-- <span class="icon icon-sm rounded-circle bg-primary-light">
                                <i class="text-primary material-icons md-local_shipping"></i>
                            </span> --}}
                                <div class="text">
                                    {{-- <h6 class="mb-1">Request info</h6>
                                <p class="mb-1">
                                    Status: {{ $dealer->delivery_status }}
                                </p> --}}
                                </div>
                            </article>
                        </div>
                        <!-- col// -->
                        <div class="col-md-12 mt-40">
                            <table class="table table-bordered">
                                <tbody>
                                    {{-- <tr>
                                        <th>Delivery Status</th>
                                        <td>
                                            <span class="badge rounded-pill alert-success text-success">{{$dealer->delivery_status}}</span>
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <th>Payment Date</th>
                                        <td>{{ date_format($dealer->created_at, 'Y/m/d') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount</th>
                                        <td>{{ $dealer->total_amount }} <strong>Tk</strong></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <!-- col// -->
                        <input type="hidden" name="dealer_id" value="{{ $dealer->user->id }}">
                        <input type="hidden" name="dealer_request_id" value="{{$dealer->id}}">
                    </div>
                    <!-- row // -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><input class="form-check-input" type="checkbox" value=""
                                                    id="select-all"></th>
                                            <th>Product Image</th>
                                            <th>Product Manufacturing Image</th>
                                            <th>Product Name</th>
                                            <th>Product Stock</th>
                                            <th>Requested Quantity</th>
                                            <th>Confirm Quantity</th>
                                            <th>Due Quantity</th>
                                            <th>Unit Price</th>

                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dealer->dealer_request_products as $key => $dealer_request_product)
                                            <tr>
                                                <td>
                                                    <input class="form-check-input checkedItem" type="checkbox"
                                                        value="{{ $dealer_request_product->product->id ?? 'null' }}"
                                                        name="product_id[]" id="select"
                                                        data-id="{{ $dealer_request_product->id }}">
                                                </td>
                                                <td>
                                                    <a class="itemside" href="#">
                                                        <div class="left">
                                                            <img src="{{ asset($dealer_request_product->product->product_thumbnail ?? ' ') }}"
                                                                width="40" height="40" class="img-xs" alt="Item">


                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <img src="{{ asset($dealer_request_product->product->menu_facture_image ?? ' ') }}"
                                                        width="40" height="40" class="img-xs" alt="Item">
                                                </td>
                                                <td>
                                                    <a class="itemside" href="#">
                                                        <div class="info">
                                                            <span class="text-bold">
                                                                {{ $dealer_request_product->product->name_en ?? ' ' }}
                                                            </span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="itemside" href="#">
                                                        <div class="info">
                                                            <span class="text-bold">
                                                                {{ $dealer_request_product->product->stock_qty ?? ' ' }}
                                                            </span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="requestQuantity" data-id="{{ $dealer_request_product->id }}">
                                                    {{ $dealer_request_product->qty ?? '0' }}
                                                    <input type="hidden"
                                                        name="requested_qty[{{ $dealer_request_product->product->id ?? 'null' }}]"
                                                        value="{{ $dealer_request_product->qty ?? '0' }}">
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        name="confirm_qty[{{ $dealer_request_product->product->id ?? 'null' }}]"
                                                        min="0" class="form-control quantity"
                                                        data-id="{{ $dealer_request_product->id }}"
                                                        value="{{ $dealer_request_product->qty ?? '0' }}">
                                                </td>
                                                <td>
                                                    <input type="hidden"
                                                        name="due_quantity[{{ $dealer_request_product->product->id ?? 'null' }}]"
                                                        data-id="{{ $dealer_request_product->id }}"
                                                        class="dueQuantityInput" value="0">
                                                    <span class="dueQuantity"
                                                        data-id="{{ $dealer_request_product->id }}">0.00</span>
                                                </td>
                                                <td class="productUnitPrice" data-id="{{ $dealer_request_product->id }}">
                                                    <input type="hidden"
                                                        name="unit_price[{{ $dealer_request_product->product->id ?? 'null' }}]"
                                                        value=" {{ $dealer_request_product->product->wholesell_price ?? '0.00' }}">
                                                    {{ $dealer_request_product->product->wholesell_price ?? '0.00' }}
                                                </td>

                                                <td class="productTotalPrice" data-id="{{ $dealer_request_product->id }}">

                                                    {{  ($dealer_request_product->product->wholesell_price ?? '0') * (int)($dealer_request_product->qty ?? '0.00') }}
                                                </td>
                                                <input type="hidden"
                                                    name="product_total_price[{{ $dealer_request_product->product->id ?? 'null' }}]"
                                                    class="productTotalPriceInput"
                                                    data-id="{{ $dealer_request_product->id }}"
                                                    value="{{ $dealer_request_product->product->wholesell_price ?? '0' * $dealer_request_product->qty ?? '0.00' }}">
                                            </tr>
                                            {{-- <input type="hidden" name="dealer_request_id"
                                                value="{{ $dealer_request_product->dealer_request_id }}"> --}}
                                        @endforeach
                                        <tr>
                                            <td colspan="7">
                                                <article class="float-end">
                                                    <dl class="dlist">
                                                        <dt>Total Amount:</dt>
                                                        <input type="hidden" name="total_amount"
                                                            id="dealerAmountTotalInput"
                                                            value="{{ $dealer->total_amount }}">
                                                        <dd><b
                                                                class="h5 dealerAmountTotal">{{ $dealer->total_amount }}</b>TK
                                                        </dd>
                                                    </dl>
                                                    <dl class="dlist">
                                                        <dt>Selected Total Amount:</dt>
                                                        <input type="hidden" name="total_selected_amount"
                                                            id="dealerAmountSelectedTotalInput" value="00.0">
                                                        <dd><b class="h5 dealerAmountSelectedTotal">00.0</b>TK
                                                        </dd>
                                                    </dl>
                                                </article>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <article class="float-end">
                                                    <dl class="dlist">
                                                        <dt>Note:</dt>
                                                        <dd>
                                                            <textarea rows="2" cols="100" class="form-control" name="comments"></textarea>
                                                        </dd>
                                                    </dl>
                                                </article>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- table-responsive// -->
                            <div class="row mb-4 justify-content-sm-end">
                                <div class="col-lg-3 col-md-4 col-sm-5 col-6">
                                    <input type="submit" class="btn btn-primary" onClick="refreshPage()"
                                        value="Confirm Order">
                                </div>
                            </div>
                        </div>
                        <!-- col// -->
                    </div>
                </div>
                <!-- card-body end// -->
            </div>
            <!-- card end// -->
        </form>
    </section>
@endsection
@push('footer-script')
    <script>
        // function refreshPage(){
        //     window.location.reload();
        // }


        $(document).ready(function() {
            $('#select-all').click(function(event) {

                if (this.checked) {
                    // Iterate each checkbox
                    $(':checkbox').each(function() {
                        this.checked = true;
                        var totalAmount = checkedCalculate();

                        $('.dealerAmountSelectedTotal').text(totalAmount);
                        $('#dealerAmountSelectedTotalInput').val(totalAmount);
                    });
                } else {
                    $(':checkbox').each(function() {
                        this.checked = false;
                    });
                    var totalAmount = checkedCalculate();

                    $('.dealerAmountSelectedTotal').text(totalAmount);
                    $('#dealerAmountSelectedTotalInput').val(totalAmount);
                }
            });

            $('.checkedItem').change(function() {
                //
                var totalAmount = checkedCalculate();

                $('.dealerAmountSelectedTotal').text(totalAmount);
                $('#dealerAmountSelectedTotalInput').val(totalAmount);
            })


            $(".quantity").change(function() {
                var quantityValue = parseInt($(this).val()) || 0;
                var id = $(this).attr('data-id');
                var currentQuantity = $(".requestQuantity[data-id='" + id + "']").text() || 0;
                if (quantityValue > currentQuantity){
                    quantityValue = currentQuantity;
                    $(this).val(quantityValue);
                }
                updateQuantity(id, quantityValue)
            })
            $(".quantity").keyup(function() {
                var quantityValue = parseInt($(this).val()) || 0;
                var id = $(this).attr('data-id');
                var currentQuantity = $(".requestQuantity[data-id='" + id + "']").text() || 0;
                if (quantityValue > currentQuantity){
                    quantityValue = currentQuantity;
                    $(this).val(quantityValue);
                }
                    updateQuantity(id, quantityValue)
            })

            function updateQuantity(id, quantity) {

                var productTotalPrice = $(".productUnitPrice[data-id='" + id + "']").text();
                var currentQuantity = $(".requestQuantity[data-id='" + id + "']").text() || 0;
                var dueQuantity = currentQuantity - quantity;
                console.log(dueQuantity)

                var newProductTotalPrice = productTotalPrice * quantity;
                console.log(newProductTotalPrice)
                $(".dueQuantity[data-id='" + id + "']").text(dueQuantity);
                $(".dueQuantityInput[data-id='" + id + "']").val(dueQuantity);
                $(".productTotalPrice[data-id='" + id + "']").text(newProductTotalPrice);
                $(".productTotalPriceInput[data-id='" + id + "']").val(newProductTotalPrice);
                calculate();

            }


            function checkedCalculate() {
                var totalAmount = 0;

                $('.checkedItem:checked').each(function() {
                    var id = $(this).attr('data-id');
                    var productPrice = parseFloat($(".productTotalPrice[data-id='" + id + "']").text());
                    totalAmount += productPrice;
                });
                return totalAmount;

            }

            function calculate() {
                var totalPrice = [];

                var totoalPricevalue = 0;

                $('.productTotalPrice').each(function() {
                    totalPrice.push(parseFloat($(this).text()));
                });

                totoalPricevalue = totalPrice.reduce(function(acc, value) {
                    return acc + value;
                }, 0);



                $(".dealerAmountTotal").text(totoalPricevalue.toFixed());
                $("#dealerAmountTotalInput").val(totoalPricevalue.toFixed());



            }




        })
    </script>
@endpush
