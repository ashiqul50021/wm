@extends('dealer.dealer_master')
@section('dealer')
    @push('css')
        <style>
            .table {
                margin-bottom: 0.5rem;
            }

            .table> :not(caption)>*>* {
                padding: 0.1rem 0.4rem;
            }

            .product-price {
                font-size: 12px;
            }

            .product-thumb {
                cursor: pointer !important;
            }

            .btn_cartInner_plus {
                margin-left: 130px;
            }

            .btn-circle {
                width: 30px;
                height: 30px;
                background-color: #d56666;
                vertical-align: center !important;
                border: none;
                float: right;
                color: #fff;
                border-radius: 50%;
            }

            .material-icons {
                vertical-align: middle !important;
                font-size: 15px !important;
            }

            .select2-container--default .select2-selection--single {
                border-radius: 0px !important;
            }

            .select2-container--default {
                width: 100% !important;
            }

            .flex-grow-1 {
                margin-right: 10px;
            }

            .product_wrapper .card-body {
                padding: 0.4rem 0.4rem;
            }

            .modal-open .modal {
                background: #000000a8 !important;
            }

            .product_stock_out {
                position: absolute;
                width: 100%;
                height: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                background: #2e2f3052;
                font-size: 17px;
                font-weight: 600;
                color: #fff;
                top: 0;
                left: 0;
                cursor: initial;
            }

            /* new pos css */

            .pos_product_image {
                width: auto;
                margin: 0px auto;
                padding: 15px 10px;
            }

            .posproduct_wrapper {
                display: flex;
                justify-content: center;
                align-items: stretch;
                flex-wrap: wrap;
                gap: 16px;
            }

            .posproduct_wrapper .product-thumb {
                width: calc(50% - 8px);
            }


            /* 576 media */
            @media(min-width: 576px) {
                .posproduct_wrapper .product-thumb {
                    width: calc(33.33% - 11px);
                }
            }


            /* media 992 */
            @media(min-width: 992px) {
                .posproduct_wrapper .product-thumb {
                    width: calc(25% - 12px);
                }
            }

            /* media 1200*/
            @media(min-width: 1200px) {
                .posproduct_wrapper .product-thumb {
                    width: calc(20% - 13px);
                }
            }

            /* media 1200*/
            @media(min-width: 1400px) {
                .posproduct_wrapper .product-thumb {
                    width: calc(15% - 26px);
                }
            }

            .posproduct_wrapper .product-thumb .card {
                margin-bottom: 0px;
            }

            .pos_product_table tr :where(th, td) {
                padding: 8px 15px !important;
            }

            .poscart_product_image {
                width: 80px;
            }

            .pos_action {
                height: 36px;
                width: 36px;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                border: none;
                color: #3bb77e;
                background: rgb(59 183 126 / 10%);
            }

            .pos_action .material-icons {
                font-size: 18px !important;

            }

            @media(min-width: 481px) {
                .pos_product_table table {
                    min-width: 1000px;
                }
            }

            .btn_cartWrapper {
                width: 180px;
                position: relative;
            }

            .btn_cartWrapper input {
                width: calc(100% - 80px);
                margin-left: 40px;
                text-align: center
            }

            .btn_cartInner {
                position: absolute;
                top: 0px;
                left: 0px;
                height: 100%;
                width: 40px;
                border: none;
                background: #3bb77e;
                color: #fff;
                font-size: 18px;
            }

            product-row-list .btn_cartInner_minus {
                right: 0px !important;
                left: auto;
            }

            .recentSelected {
                border: 2px solid #3BB77E;
                background: #3BB77E;
                border-radius: 15px;
            }



            #scrollToBottomBtn {
                position: fixed;
                bottom: 20px;
                right: 20px;
                background-color: #007bff;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                z-index: 9999;
                /* Ensure the button stays on top of other elements */
            }

            #scrollToBottomBtn:hover {
                background-color: #0056b3;
            }

            /* new pos css end*/
        </style>
    @endpush
    <section class="content-main">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input class="form-control" type="text" name="search_term" id="search_term"
                                            placeholder="Search by Name">
                                    </div>

                                    {{-- <div class="col-sm-3">
                                        <form method="GET">
                                            <select id="items-per-page">
                                                <option value="10"
                                                    {{ request()->input('items_per_page') == 10 ? 'selected' : '' }}>Show 10
                                                </option>
                                                <option value="20"
                                                    {{ request()->input('items_per_page') == 20 ? 'selected' : '' }}>Show 20
                                                </option>
                                                <option value="50"
                                                    {{ request()->input('items_per_page') == 50 ? 'selected' : '' }}>Show 50
                                                </option>
                                            </select>
                                            <button type="submit">get</button>
                                        </form>


                                    </div> --}}

                                    {{-- <div class="col-sm-3">
                                        <div class="custom_select">
                                            <select name="category_id" id="category_id"
                                                class="form-control select-active w-100 form-select select-nice"
                                                onchange="filter()">
                                                <option value="">-- Select Category --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name_en }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-sm-2">
                                        {{-- <input class="form-control" type="text" name="search_term_barcode" id="search_term_barcode" placeholder="Search by Barcode" onkeyup="filterByBarcode()"> --}}
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- card-body end// -->
                    </div>
                </div>
                <!-- product row -->
                <div class="posproduct_wrapper product_wrapper product-row" id="product_wrapper">
                    @foreach ($products as $product)
                        <div class="col-sm-2 col-xs-6 product-thumb product-row-list" id="productCard_{{ $product->id }}"
                            onclick="addToList({{ $product->id }})">
                            <div class="card mb-4 mt-4">
                                <div class="card-body position-relative text-center">
                                    <div class="product-image pos_product_image">
                                        @if ($product->product_thumbnail && $product->product_thumbnail != '' && $product->product_thumbnail != 'Null')
                                            <img class="default-img" src="{{ asset($product->product_thumbnail) }}"
                                                alt="">
                                        @else
                                            <img class="default-img" src="{{ asset('upload/no_image.jpg') }}"
                                                alt="">
                                        @endif
                                    </div>
                                    <p style="font-size: 14px; font-weight: bold; line-height: 15px;">
                                        <?php $p_name_en = strip_tags(html_entity_decode($product->name_en)); ?>
                                        {{ Str::limit($p_name_en, $limit = 30, $end = '. . .') }}
                                    </p>
                                    <input type="hidden" id="pv_type_{{ $product->id }}" value="0">
                                    <p style="font-size: 13px; font-weight: bold; line-height: 14px; margin-top: 5px;">
                                        Stock: @if ($product->stock_qty == 0)
                                            <span class="text-danger">Stock Out</span>
                                        @else
                                            {{ $product->stock_qty }}
                                        @endif
                                    </p>
                                    <input type="hidden" id="product_stock_{{ $product->id }}"
                                        value="{{ $product->stock_qty }}">
                                    <div>
                                        @php
                                            if ($product->discount_type == 1) {
                                                $price_after_discount =
                                                    $product->regular_price - $product->discount_price;
                                            } elseif ($product->discount_type == 2) {
                                                $price_after_discount =
                                                    $product->regular_price -
                                                    ($product->regular_price * $product->discount_price) / 100;
                                            }
                                        @endphp
                                        <div class="product-price">
                                            <del class="old-price">৳{{ $product->regular_price }}</del>
                                            <span class="price text-primary">৳{{ $product->wholesell_price }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-xs d-flex mx-auto my-4" id="seemore">Load More <i
                        class="fi-rs-arrow-small-right"></i></button>
            </div>

            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="submitForm" action="{{ route('dealer.pos.request.store') }}" method="POST">
                            @csrf
                            <div class="border-bottom pb-3">
                                <!-- pos product table end -->
                                <div class="">
                                    <input class="form-control" id="dealerID" type="hidden" name="dealer_id"
                                        value="{{ Auth::guard('dealer')->user()->id }}">
                                    <input class="form-control" type="text"
                                        value="{{ Auth::guard('dealer')->user()->name }}" readonly>
                                </div>


                            </div>
                            <div>
                                <div class="row">
                                    <div class="pos_product_table table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Title</th>
                                                    <th>Qunatity</th>

                                                    <th>Unit Price</th>
                                                    <th>Total Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="checkout_list">


                                            </tbody>
                                        </table>
                                    </div>

                                    <hr>
                                </div>
                            </div>
                            <!-- card total count -->
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Sub Total</td>
                                                <td style="float: right;" class="my-2"><input type="number"
                                                        id="subtotal_text" name="subtotal" class="form-control" readonly
                                                        value="0.00"></td>
                                            </tr>
                                            <tr>
                                                <td>Noted</td>
                                                <td style="float: right;" class="my-2">
                                                    <textarea type="text" id="comments" name="comment" class="form-control"></textarea>
                                                </td>
                                            </tr>
                                            <div class="clearfix"></div>
                                            <input type="hidden" id="posProducts">

                                        </tbody>
                                    </table>
                                    <hr>
                                    <table class="table">
                                        <tbody>
                                            <tr style="font-size: 20px; font-weight: bold">
                                                <td>Total</td>
                                                <td style="float: right;">৳ <span id="total_text">0.00</span></td>
                                                <input type="hidden" id="total" name="grand_total" value="0">
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">

                                </div>
                                <div class="col-sm-6">
                                    <input type="submit" class="btn btn-primary" value="Place Order" style="float: right;">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- card-body end// -->
                </div>
            </div>
        </div>
    </section>

    <button id="scrollToBottomBtn">Tap to Bottom</button>
@endsection

@push('footer-script')
    <script>
        $(document).ready(function() {
            $('body').addClass('aside-mini');
        });



        var storedProducts = localStorage.getItem('addedProducts');
        var addedProducts = JSON.parse(storedProducts) || {};
        if (storedProducts) {
            addedProducts = JSON.parse(storedProducts);
            afterUpdate(addedProducts);
            calculate();
        }

        function addToList(id) {

            var productCard = $('#productCard_' + id);

            if (productCard.hasClass('recentSelected')) {
                productCard.removeClass('recentSelected');
            } else {
                productCard.addClass('recentSelected');
            }
            $.ajax({
                type: 'GET',
                url: '/dealer/pos/product/' + id,
                dataType: 'json',
                success: function(data) {
                    if (addedProducts.hasOwnProperty(data.id)) {
                        addedProducts[data.id].quantity++;
                        var wholePrice = addedProducts[data.id].data.wholesell_price;

                        addedProducts[data.id].price = parseFloat(wholePrice) * addedProducts[data.id].quantity;
                        updateQuantity(data.id, addedProducts[data.id].quantity);
                    } else {
                        addedProducts[data.id] = {
                            quantity: 1,
                            data: data,
                            price: data?.wholesell_price
                        };
                    }
                    localStorage.setItem('addedProducts', JSON.stringify(addedProducts));
                    afterUpdate(addedProducts);
                    calculate()


                }
            });
        }


        // after update
        function afterUpdate(addedProducts) {

            var items = Object.values(addedProducts);
            if (!items.length > 0) {
                $('#checkout_list').empty();
                $('#checkout_list').html(`<div class="text-center pt-10 pb-10" id="no_product_text">
                                         <span>No Product Added</span>
                                     </div>`);
                $("#subtotal_text").val(0)
                $("#total_text").text(0)

            } else {
                var results = '';
                for (var i = 0; i < items.length; i++) {
                    var singledata = items[i];
                    console.log('singleDatafound', singledata);
                    // console.log(window.location.origin + "/" + singledata?.data?.product_thumbnail);

                    var totalPrice = singledata?.quantity * singledata?.data?.wholesell_price;
                    var htmlItem = `
                                    <tr data-id="${singledata?.data?.id}">
                                        <td>
                                            <div class="poscart_product_image">
                                                <img src="${window.location.origin}/${singledata?.data?.product_thumbnail}" alt="">
                                            </div>
                                        </td>
                                        <td>
                                            <input type="hidden" class="productId" name="product_id[]" value="${singledata?.data?.id}">
                                            <p>${singledata?.data?.name_en}</p>
                                        </td>
                                        <td>
                                            <div class="btn_cartWrapper">
                                                <button class="btn_cartInner btn_cartInner_plus" type="button" onClick="cart_increase(${singledata?.data?.id})"><i class="fa-solid fa-plus"></i></button>
                                                <input type="number" min="1" class="qty form-control bg-transparent quantityInput" data-id="${singledata?.data?.id}" name="qty[]" value=${singledata?.quantity}>
                                                <button class="btn_cartInner btn_cartInner_minus" type="button" onClick="cart_decrease(${singledata?.data?.id})"><i class="fa-solid fa-minus"></i></button>
                                            </div>

                                        </td>
                                        <td>
                                            <input type="hidden" class="unitPriceId" name="unit_price[]" value="${singledata?.data?.wholesell_price.toFixed(2)}">
                                            <span data-id="${singledata?.data?.id}" class="unitPrice">${singledata?.data?.wholesell_price.toFixed(2)}</span>

                                        </td>
                                        <td>
                                            <span data-id="${singledata?.data?.id}" class="itemTotalPriceTxt">${totalPrice.toFixed(2)}</span>
                                            <input data-id="${singledata?.data?.id}" type='hidden' name="price[]" class="price priceForValue" value="${totalPrice.toFixed(2)}">
                                            </td>


                                        <td>
                                            <button type="button" class="m-auto float-none pos_action  remove-item">
                                                <i class="material-icons md-delete"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    `;
                    results += htmlItem;
                }
                $('#checkout_list').empty();
                $('#checkout_list').html(results);

            }
        }



        function updateQuantity(productId, newQuantity) {

            addedProducts[productId].quantity = newQuantity;

            var productData = addedProducts[productId].data;
            var newTotalPrice = productData.wholesell_price * newQuantity;

            $(".qty[data-id='" + productId + "']").val(newQuantity);
            var totalPrice = $(`.itemTotalPriceTxt${productId}`).text();
            $('.itemTotalPriceTxt[data-id="' + productId + '"]').text(newTotalPrice.toFixed(2));
            $('.price[data-id="' + productId + '"]').val(newTotalPrice.toFixed(2));
            localStorage.setItem('addedProducts', JSON.stringify(addedProducts));



        }


        function cart_increase(productId) {

            const newQuantity = addedProducts[productId].quantity + 1;
            updateQuantity(productId, newQuantity);
            calculate()

        }

        function cart_decrease(productId) {
            const newQuantity = addedProducts[productId].quantity - 1;
            if (newQuantity >= 1) {
                updateQuantity(productId, newQuantity);
            }
            calculate()
            localStorage.setItem('addedProducts', JSON.stringify(addedProducts));
        }

        //  Remove item
        $(document).on("click", ".remove-item", function() {
            var itemId = $(this).closest("tr").data("id");
            $(this).closest("tr").remove();
            delete addedProducts[itemId];


            calculate()
            localStorage.setItem('addedProducts', JSON.stringify(addedProducts));
        });


        function calculate() {
            var totalPrice = [];

            var totoalPricevalue = 0;

            $('.itemTotalPriceTxt').each(function() {
                totalPrice.push(parseFloat($(this).text()));
            });

            totoalPricevalue = totalPrice.reduce(function(acc, value) {
                return acc + value;
            }, 0);


            $("#subtotal_text").val(totoalPricevalue.toFixed());
            $("#total_text").text(totoalPricevalue.toFixed());
            $("#total").val(totoalPricevalue.toFixed());



        }


        $(document).on("keyup", ".quantityInput", function() {
            var productId = $(this).attr('data-id');
            var value = parseFloat($(this).val()) || 0;
            updateQuantity(productId, value);
            calculate()
        });


        // submit form

        // Assuming you have a form with the id "your-form-id"
        $('#submitForm').submit(function(event) {
            event.preventDefault();

            var url = $(this).attr('action');
            var dealerId = $('#dealerID').val();
            var grandTotal = $('#total').val();
            var comments = $('#comments').val() || null;
            var productId = [];
            $('.productId').each(function() {
                var productValue = $(this).val();
                productId.push(productValue);
            });
            var unitPriceId = [];
            $('.unitPriceId').each(function() {
                var productValue = $(this).val();
                unitPriceId.push(productValue);
            });

            var quantity = [];
            $('.qty').each(function() {
                var qty = $(this).val();
                quantity.push(qty);
            });

            var priceforproduct = [];
            $('.priceForValue').each(function() {
                var pricevalue = $(this).val();
                priceforproduct.push(pricevalue);
            });


            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    dealer_id: dealerId,
                    grand_total: grandTotal,
                    comment: comments,
                    product_id: productId,
                    unit_price: unitPriceId,
                    qty: quantity,
                    price: priceforproduct
                },
                success: function(response) {


                    if (response?.status == 1) {
                        localStorage.clear();
                        toastr.success(response.message);
                        var route = "{{ route('dealer.all_request.index') }}";
                        window.location.href = route;
                    } else {
                        toastr.warning(response.message);

                    }





                },
                error: function() {

                }
            });
        });
    </script>
    <script>
        // Initially hide all product rows
        $(".product-row .product-row-list").hide();

        // Initially show the first 18 products
        $(".product-row .product-row-list").slice(0, 18).show();

        // Click event for "Load More" button
        $("#seemore").click(function() {
            // Select both initially loaded and dynamically loaded hidden products
            $(".product-row .product-row-list:hidden").slice(0, 18).slideDown();

            // If no more hidden products, hide the "Load More" button
            if ($(".product-row .product-row-list:hidden").length === 0) {
                $("#seemore").fadeOut('slow');
            }
        });
        // filter

        $(document).on("keyup", "#search_term", function() {
            var value = $(this).val();
            var url = "{{ route('dealer.pos.filter') }}";
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: {
                    value,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    var items = data;
                    var results = '';

                    for (var i = 0; i < items.length; i++) {
                        var singledata = items[i];
                        var thumbnail = window.location.origin + '/' + singledata?.product_thumbnail;

                        var p_name_en = singledata.name_en || '';
                        var htmlItem = `

                        <div class="product-thumb product-row-list" onclick="addToList(${singledata.id})"}>
                    <div class="card">
                        <div class="card-body position-relative text-center">
                            <div class="product-image pos_product_image">
                                @if ($product->product_thumbnail && $product->product_thumbnail != '' && $product->product_thumbnail != 'Null')
                                    <img class="default-img" src="${singledata?.product_thumbnail && thumbnail}"
                                        alt="">
                                @else
                                    <img class="default-img" src="{{ asset('upload/no_image.jpg') }}"
                                        alt="">
                                @endif
                            </div>
                            <p style="font-size: 14px; font-weight: bold; line-height: 15px;">
                                ${p_name_en.substr(0, 30) + (p_name_en.length > 30 ? '...' : '')}
                            </p>
                            <input type="hidden" id="pv_type_${singledata.id}" value="0">
                            <p  style="font-size: 13px; font-weight: bold; line-height: 14px; margin-top: 5px;">
                                Stock: ${singledata.stock_qty === 0 ? '<span class="text-danger">Stock Out</span>' : singledata.stock_qty}
                            </p>
                            <input type="hidden" id="product_stock_${singledata.id}" value="${singledata.stock_qty}">
                            <div>
                                @php
                                    if ($product->discount_type == 1) {
                                        $price_after_discount = $product->regular_price - $product->discount_price;
                                    } elseif ($product->discount_type == 2) {
                                        $price_after_discount = $product->regular_price - ($product->regular_price * $product->discount_price) / 100;
                                    }
                                @endphp
                                <div class="product-price">
                                    <del class="old-price">৳${singledata.regular_price}</del>
                                    <span class="price text-primary">৳${singledata.wholesell_price}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              `;
                        results += htmlItem;
                    }

                    $('#product_wrapper').empty();
                    $('#product_wrapper').html(results);

                    $(".product-row .product-row-list").hide();
                    $(".product-row .product-row-list").slice(0, 18).show();


                    $("#seemore").show();


                }
            });
        });


        /* ================ Load More Product show ============ */
        $(".product-row .product-row-list").hide();
        $(".product-row .product-row-list").slice(0, 18).show();
        $("#seemore").click(function() {
            $(".product-row .product-row-list:hidden").slice(0, 18).slideDown();
            if ($(".product-row .product-row-list:hidden").length == 0) {
                $("#load").fadeOut('slow');
            }
        });




        // tap to bottom button
        $(document).on("click", "#scrollToBottomBtn", function() {
            window.scrollTo(0,document.body.scrollHeight);
        })
    </script>
@endpush
