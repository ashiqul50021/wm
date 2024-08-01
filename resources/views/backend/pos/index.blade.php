@extends('admin.admin_master')
@section('admin')
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

            table.noyon-table {
                max-width: 500px;
                margin-left: auto;
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

            .btn_cartInner_minus {
                right: 0px !important;
                left: auto;
            }

            .recentSelected {
                border: 2px solid #3BB77E;
                background: #3BB77E;
                border-radius: 15px;
            }

            /* new pos css end*/
        </style>
    @endpush
    <section class="content-main">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="mb-4 card">
                        <div class="card-body">
                            <form action="">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" name="search_term" id="search_term"
                                            placeholder="Search by Name" onkeyup="filter()">
                                    </div>
                                    <div class="col-sm-3">
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
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- card-body end// -->
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2 col-lg-12 d-flex justify-content-end">
                        <button id="scrollToBottomButton" class="btn btn-primary"> <i
                                class="p-1 fas fa-arrow-down fs-6"></i></button>
                    </div>
                </div>
                <div class="container-fluid">
                    <select id="productCountSelector" class="p-2 px-3 mb-2 border rounded">
                        <option value="10">Show 10 Products</option>
                        <option value="20">Show 20 Products</option>
                        <option value="30">Show 30 Products</option>
                        <option value="40">Show 40 Products</option>
                        <option value="">Show All Products</option>
                    </select>
                    <div class="pt-2 row product_wrapper product-row" id="product_wrapper">
                        @foreach ($products as $product)
                            {{-- <div class="col-sm-2 col-xs-6 product-thumb product-row-list"
                                @if ($product->stock_qty > 0) onclick="addToList({{ $product->id }})" @endif> --}}
                            <div class="col-sm-2 col-xs-6 product-thumb product-row-list"
                                id="productCard_{{ $product->id }}"
                                @if ($product->stock_qty > 0) onclick="addToList({{ $product->id }})" @endif>
                                <div class="mt-4 mb-4 card">
                                    <div class="card-body position-relative">
                                        @if ($product->stock_qty <= 0)
                                            <div class="product_stock_out">Stock Out</div>
                                        @endif
                                        <div class="product-image">
                                            @if ($product->product_thumbnail && $product->product_thumbnail != '' && $product->product_thumbnail != 'Null')
                                                <img class="default-img" src="{{ asset($product->product_thumbnail) }}"
                                                    alt="">
                                            @else
                                                <img class="default-img" src="{{ asset('upload/no_image.jpg') }}"
                                                    alt="">
                                            @endif
                                        </div>
                                        <p
                                            style="font-size: 10px; font-weight: bold; line-height: 15px; padding-top: 30px;">
                                            {{ $product->name_en }}
                                        </p>
                                        <input type="hidden" id="pv_type_{{ $product->id }}" value="0">
                                        <p style="font-size: 10px; font-weight: bold; line-height: 10px; padding-top: 0px;">
                                            Stock: {{ $product->stock_qty }}
                                        </p>
                                        <p style="font-size: 10px; font-weight: bold; line-height: 10px; padding-top: 0px;">
                                            Purchase Code: {{ $product->purchase_code }}
                                        </p>
                                        @if ($product->model_number !== null)
                                            <p
                                                style="font-size: 10px; font-weight: bold; line-height: 10px; padding-top: 0px;">
                                                Model No: {{ $product->model_number ?? '' }}
                                            </p>
                                        @endif

                                        <input type="hidden" id="product_stock_{{ $product->id }}"
                                            value="{{ $product->stock_qty }}">
                                        <div>
                                            @if ($product->discount_price > 0)
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
                                                @if($product->discount_type == 1)
                                                    <div class="product-price">
                                                        <span class="price text-primary">off: ৳{{ $product->discount_price }}</span>
                                                        <del class="old-price">৳{{ $product->regular_price }}</del>
                                                        <span class="price text-primary">৳{{ $price_after_discount }}</span>
                                                    </div>
                                                @elseif($product->discount_type == 2)
                                                    <div class="product-price">
                                                        <span class="price text-primary">off: {{  (($product->discount_price) / 100) * 100 }}%</span>
                                                        <del class="old-price">৳{{ $product->regular_price }}</del>
                                                        <span class="price text-primary">৳{{ $price_after_discount }}</span>
                                                    </div>
                                                    @endif
                                            @else
                                                <div class="product-price">
                                                    <span class="price text-primary">৳{{ $product->regular_price }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
                {{-- <button class="mx-auto my-4 btn btn-xs d-flex" id="seemore">Load More <i
                        class="fi-rs-arrow-small-right"></i></button> --}}
            </div>
            <div class="col-sm-12">
                <div class="mb-4 card">
                    <div class="card-body">
                        {{-- <div class="mb-3">
                            <input class="form-control" type="text" name="barcode_search_term" id="barcode_search_term"
                                placeholder="Search by Barcode" oninput="barcode()">
                        </div> --}}
                        <div class="row">
                            <h4>Customer Info</h4>

                            <div class="mt-4 mb-4 col-md-3">
                                <label for="form-label">Customer Name</label>
                                <input type="text" name="customerName" id="customerName"
                                    class="form-control customerNameChange">
                                <div style="background: white; color:black">
                                    <ul class="suggestCustomerName">

                                    </ul>
                                </div>
                            </div>
                            <div class="mt-4 mb-4 col-md-3">
                                <label for="form-label">Customer Phone</label>
                                <input type="number" name="customerPhone" max="11" id="customerPhone"
                                    class="form-control customerPhoneChange">
                                <div style="background: white; color:black">
                                    <ul class="suggestCustomerPhone">

                                    </ul>
                                </div>
                            </div>
                            <div class="mt-4 mb-4 col-md-3">
                                <label for="form-label">Customer Email</label>
                                <input type="email" name="customerEmail" id="customerEmail" class="form-control">
                            </div>
                            <div class="mt-4 mb-4 col-md-3">
                                <label for="form-label">Customer Address</label>

                                <input type="text" name="customerAddress" id="customerAddress"
                                    class="form-control customerAddressChange">

                            </div>

                            {{-- <div class="mt-5 col-md-4 ">
                                <a style="background-color: #454847; "class="mt-5 text-white btn btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#customer1">Create Customer</a>
                            </div> --}}

                        </div>
                        <form action="{{ route('pos.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="customer_id" id="customerId" value="0">
                            <input type="hidden" name="customerPhoneFind" id="customerphoneId" value="0">
                            <input type="hidden" name="customerNameFind" id="customernameId" value="0">
                            <input type="hidden" name="customerAddressFind" id="customerAddressId" value="0">

                            <div class="pb-3 d-flex border-bottom">
                                {{-- <div class="flex-grow-1">
                                    <select name="customer_id" id="customer_id"
                                        class="form-control select-active w-100 form-select select-nice" required>
                                        <option value="0">-- Walking Customer --</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

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
                                                    <th>Discount</th>
                                                    <th>Discount type</th>
                                                    <th>Unit Price</th>
                                                    <th>Discount Amount</th>
                                                    <th>Total Price</th>
                                                    <th>Total After Discount</th>
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
                            <div class="row">
                                <table class="table noyon-table">
                                    <tbody>
                                        <tr>
                                            <td>Sub Total</td>
                                            <td style="float: right;" class="my-2"><input type="number"
                                                    id="subtotal_text" name="subtotal" class="form-control" readonly
                                                    value="0.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Total Discount Price</td>
                                            <td style="float: right;" class="my-2"><input type="number"
                                                    id="totalDiscount" name="totalDiscountAmount" class="form-control"
                                                    readonly value="0.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Discount</td>
                                            {{-- <td style="float: right;">৳ 0.00</td> --}}
                                            <td style="float: right;" class="my-2"> <input type="number"
                                                    id="discountMain" name="discount" class="form-control"
                                                    value="0.00" /></td>
                                        </tr>
                                        <tr>
                                            <td>Overall Discount</td>
                                            {{-- <td style="float: right;">৳ 0.00</td> --}}
                                            <td style="float: right;" class="my-2"> <input type="number"
                                                    id="overallDiscount" name="overallDiscount" class="form-control"
                                                    value="0.00" /></td>
                                        </tr>
                                        <tr>
                                            <td>Paid Amount</td>
                                            <td style="float: right;" class="my-2"> <input type="number"
                                                    id="paid_amount" name="paid_amount" class="form-control"
                                                    value="0.00" /></td>
                                        </tr>
                                        <tr>
                                            <td>Due Amount</td>
                                            <td style="float: right;" class="my-2"> <input type="number"
                                                    id="due_amount" name="due_amount" readonly class="form-control"
                                                    value="0.00" /></td>
                                        </tr>
                                        <tr>
                                            <td>Message</td>
                                            <td style="float: right;" class="my-2">
                                                <textarea name="note" id="note" class="form-control" cols="30" rows="10"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sale By</td>
                                            <td style="" class="my-2">
                                                <select name="staff_id"
                                                    class="form-control select-active w-100 form-select select-nice">
                                                    <option value="0">-- Select Staff --</option>
                                                    @foreach ($staffs as $staff)
                                                        <option value="{{ $staff->user_id }}">{{ $staff->user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
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
                                            <input type="hidden" id="grandTotal" name="grand_total" value="0">

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">

                                </div>
                                <div class="col-sm-6">
                                    <input type="submit" id="refresh" class="btn btn-primary" value="Place Order"
                                        style="float: right;">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- card-body end// -->
                </div>
            </div>
            <div class="row">
                <div class="mb-2 col-lg-12 d-flex justify-content-end">
                    <button id="scrollToUpButton" class="btn btn-primary"> <i class="p-1 fas fa-arrow-up fs-6"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>


    <!--  Customer Modal -->
    <div class="modal fade" id="customer1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h3>Customer Create</h3>
                    <button type="button" class="bg-white btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="customer_store" action="">
                        <input type="hidden" name="_token" id="csrf" value="{{ Session::token() }}">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-1">
                                    <label class="col-form-label" style="font-weight: bold;">Name: <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        placeholder="Write Customer Name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-1">
                                    <label class="col-form-label" style="font-weight: bold;">Phone: <span
                                            class="text-danger">*</span></label>
                                    <input type="number" max="11" placeholder="Write Phone" id="phone"
                                        name="phone" required class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-1">
                                    <label class="col-form-label" style="font-weight: bold;">Email:</label>
                                    <input type="email" placeholder="Write Email" id="email" name="email"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-1">
                                    <label class="col-form-label" style="font-weight: bold;">Address: <span
                                            class="text-danger">*</span></label>
                                    <input type="text" placeholder="Write Address" id="address" name="address"
                                        required class="form-control">
                                </div>
                            </div>
                            <div class="mt-2 mb-1">
                                <img id="showImage" class="rounded avatar-lg"
                                    src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                    alt="Card image cap" width="100px" height="80px;">
                            </div>
                            <div class="mb-1">
                                <label for="image" class="col-form-label" style="font-weight: bold;">Profile
                                    Image:</label>
                                <input name="profile_image" class="form-control" type="file" id="image">
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="Close" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <!-- Ajax Update Category Store -->

    <script type="text/javascript">
        $(document).ready(function(e) {

            // get customer info
            $('#customerName').keyup(function() {
                var customerName = $('#customerName').val();


                var url = "{{ route('pos.getCustomer') }}";
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        customerName: customerName,
                        _token: '{{ csrf_token() }}'

                    },
                    success: function(response) {
                        // Handle the response here
                        console.log('suggession name', response);
                        $('.suggestCustomerName').empty();
                        $.each(response, function(i, suggestion) {

                            $('.suggestCustomerName').append(
                                `<li><button class="btn suggestion-btn" type="button" data-id="${suggestion.id}" data-name="${suggestion.name}" data-phone="${suggestion.phone}" data-email="${suggestion.email}">${suggestion.name}</button></li>`
                            );
                        });


                        $('.suggestion-btn').click(function() {
                            var suggestionName = $(this).data('name');
                            var suggestionPhone = $(this).data('phone');
                            var suggestionEmail = $(this).data('email');
                            var suggestionId = $(this).data('id');


                            $('#customerName').val(suggestionName);
                            $('#customerPhone').val(suggestionPhone);
                            $('#customerEmail').val(suggestionEmail);
                            $('#customerId').val(suggestionId);

                            $('.suggestCustomerName').empty(); // Clear suggestions
                        });
                        // toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                    }
                });

            })
            $('#customerPhone').keyup(function() {
                var customerPhone = $('#customerPhone').val();


                var url = "{{ route('pos.getCustomerByPhone') }}";
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        customerPhone: customerPhone,
                        _token: '{{ csrf_token() }}'

                    },
                    success: function(response) {
                        // Handle the response here

                        $('.suggestCustomerPhone').empty();
                        $.each(response, function(i, suggestion) {

                            $('.suggestCustomerPhone').append(
                                `<li><button class="btn suggestion-btn" type="button" data-id="${suggestion.id}" data-name="${suggestion.name}" data-phone="${suggestion.phone}" data-email="${suggestion.email}">${suggestion.phone}</button></li>`
                            );
                        });


                        $('.suggestion-btn').click(function() {
                            var suggestionName = $(this).data('name');
                            var suggestionPhone = $(this).data('phone');
                            var suggestionEmail = $(this).data('email');
                            var suggestionId = $(this).data('id');
                            $('#customerName').val(suggestionName);
                            $('#customerPhone').val(suggestionPhone);
                            $('#customerEmail').val(suggestionEmail);
                            $('#customerId').val(suggestionId);
                            $('.suggestCustomerPhone').empty(); // Clear suggestions
                        });
                        // toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                    }
                });

            })

            $('#customer_store').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('customer.ajax.store.pos') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {

                        $('select[name="customer_id"]').html(
                            '<option value="" selected="" disabled="">-- Select Customer --</option>'
                        );
                        $.each(data.customers, function(key, value) {
                            $('select[name="customer_id"]').append('<option value="' +
                                value.id + '">' + value.name + '</option>');
                        });


                        $('#showImage').val('');
                        $('#phone').val('');
                        $('#email').val('');
                        $('#address').val('');
                        this.reset();

                        if ($.isEmptyObject(data.error)) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            })
                            Toast.fire({
                                type: 'success',
                                title: data.success
                            })
                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 2000
                            })
                            Swal.fire({
                                icon: 'error',
                                title: data.error,
                            })
                        }
                        // End Message
                        $('#Close').click();
                    },

                    error: function(data) {
                        $.each(data.responseJSON.errors, function(key, value) {

                            var Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 2000,
                            })
                            Toast.fire({
                                title: value
                            })

                        });

                    }
                });
            });


        });

        // new update

        $(document).on("change", '.customerPhoneChange', function() {
            var phone = $(this).val();
            console.log("customer phone", phone);
            $('input[name="customerPhoneFind"]').val(phone);
        })
        $(document).on("change", '.customerNameChange', function() {
            var name = $(this).val();
            console.log("customer name", name);
            $('input[name="customerNameFind"]').val(name);
        })
        $(document).on("change", '.customerAddressChange', function() {
            var name = $(this).val();
            console.log("customer address", name);
            $('input[name="customerAddressFind"]').val(name);
        })
    </script>

    <script>
        $(document).ready(function() {
            $('body').addClass('aside-mini');
            // calculate()
            getPosProductList()

        });

        function getPosProductList() {
            var url = "{{ route('pos.getPosProduct') }}";
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {

                    afterUpdate(data)
                    calculate()

                }
            })
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
                url: "{{ route('pos.getProduct', '') }}" + "/" + id,
                dataType: 'json',
                success: function(data) {


                    addtoListProduct(data)

                    // afterUpdate(data)




                }
            });
        }



        function addtoListProduct(addedProducts) {

            var url = "{{ route('pos.addToList') }}";
            var productId = addedProducts?.id;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    addedProducts,
                    _token: '{{ csrf_token() }}'
                },
                success: (data) => {
                    if (data.status == 'false') {
                        console.log("stock nai")
                        setTimeout(() => {
                            toastr.error(data?.message);
                        }, 500)
                    } else {
                        afterUpdate(data)
                        calculate()
                        setTimeout(() => {
                            toastr.success(data?.message);
                        }, 500)
                    }
                }

            })
        }



        // after update
        function afterUpdate(data) {

            var items = data.data;

            if (!items.length > 0) {
                $('#checkout_list').empty();
                $('#checkout_list').html(`<div class="pt-10 pb-10 text-center" id="no_product_text">
                <span>No Product Added</span>
            </div>`);
                $("#subtotal_text").val(0)
                $("#total_text").text(0)

            } else {
                var results = '';
                for (var i = 0; i < items.length; i++) {
                    var singledata = items[i];
                    var afterDiscountFromRegular = singledata?.data?.regular_price - singledata?.data
                        ?.discount_price ?? 0;

                    var totalPrice = afterDiscountFromRegular * singledata?.quantity;

                    var htmlItem = `
                    <tr data-id="${singledata?.product?.id}">
                    <td>
                   <div class="poscart_product_image">
                       <img src="${window.location.origin}/${singledata.product_image}" alt="">
                       <input type="hidden" name="product_thumbnail[]" value="${singledata.product_image}">
                   </div>
               </td>
               <td>
                   <input type="hidden" class="productId" name="product_id[]" value="${singledata?.product?.id}">
                   <p>${singledata?.product?.name_en}</p>
                   <input type="hidden" name='name_en[]' value="${singledata?.product?.name_en}">
               </td>
               <td>
                   <div class="btn_cartWrapper">
                       <button class="btn_cartInner" type="button" onClick="cart_increase(${singledata?.product?.id})"><i class="fa-solid fa-plus"></i></button>
                       <input type="number" min="1" class="bg-transparent qty form-control quantityInput" data-id="${singledata?.product?.id}" name="product_qty[]" value=${singledata?.quantity}>
                       <button class="btn_cartInner btn_cartInner_minus" type="button" onClick="cart_decrease(${singledata?.product?.id})"><i class="fa-solid fa-minus"></i></button>
                   </div>

               </td>


               <td>
                   <input type="number" min="0" name="discount_input[]" data-id=${singledata?.product?.id} class="bg-transparent form-control discountInput" value=${singledata?.discount}>
               </td>
               <td>
                   <select name="discount_type[]" id="" class="bg-transparent form-select discountType" data-id=${singledata?.product?.id}>

                       <option ${singledata?.discount_type == 'flat' ? 'selected' : ''} value="flat">Flat</option>
                       <option  ${singledata?.discount_type == 'percentage' ? 'selected' : ''} value="percentage">Percentage</option>
                   </select>
               </td>

               <td>

                   <input type="number" name="unit_price[]" class="unitPriceInput form-control" data-id="${singledata?.product?.id}" value="${singledata?.unit_price}" step="any">
               </td>
               <td class="discountAfterInput" data-id="${singledata?.product?.id}">${singledata?.discount_amount ?? '0'}</td>
               <input type="hidden" name="discount_amount[]" value="${singledata?.discount_amount ?? '0'}" class="discountAfterInputValue" data-id="${singledata?.product?.id}">
               <td>
                   <span data-id="${singledata?.product?.id}" class="itemTotalPriceTxt">${singledata?.total_price}</span>
                   <input data-id="${singledata?.product?.id}" type='hidden' name="totalPrice[]" class="price priceForValue" value="${singledata?.total_price}">
                   </td>
               <td>
                   <span data-id="${singledata?.product?.id}" class="itemTotalAfterDiscountTxt">${singledata?.after_discount_price}</span>
                   <input data-id="${singledata?.product?.id}" type='hidden' name="total_after_discount[]" class="totalAfterDiscount" value="${singledata?.after_discount_price}">
                </td>


               <td>
                   <button type="button" class="float-none m-auto pos_action remove-item">
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
            var url = "{{ route('pos.updateQuantity', '') }}" + "/" + productId;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    newQuantity: newQuantity, // Corrected key-value assignment
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.status == 'false') {
                        console.log("stock nai");
                        setTimeout(() => {
                            toastr.error(data?.message);
                        }, 500)
                    } else {
                        afterUpdate(data)
                        calculate()
                        setTimeout(() => {
                            toastr.success(data?.message);
                        }, 500)
                    }


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                }
            });
        }

        // increate item
        function cart_increase(productId) {

            var quantity = parseInt($('.quantityInput[data-id="' + productId + '"]').val());

            var newQuantity = quantity + 1;

            updateQuantity(productId, newQuantity)

        }


        // decrease item
        function cart_decrease(productId) {
            var quantity = parseInt($('.quantityInput[data-id="' + productId + '"]').val());

            if (quantity > 1) {
                var newQuantity = quantity - 1;
                updateQuantity(productId, newQuantity);

            } else {
                alert('Quantity cannot be less than 1.');
            }
        }

        // unit price change
        $(document).on("change", ".unitPriceInput", function() {
            var productId = $(this).attr('data-id');
            var updatedUnitPrice = $(this).val();
            console.log("update value", productId, updatedUnitPrice)

            var url = "{{ route('pos.updateUnitPrice', '') }}" + "/" + productId;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    unit_price: updatedUnitPrice, // Corrected key-value assignment
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {

                    afterUpdate(data)
                    calculate()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                }
            });

        })

        //  Remove item
        $(document).on("click", ".remove-item", function() {
            var itemId = $(this).closest("tr").data("id");


            var url = "{{ route('pos.removeProduct', '') }}" + "/" + itemId;

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {

                    afterUpdate(data)
                    calculate()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                }
            });
        });


        function calculate() {
            var totalSubtotal = [];
            var totalDiscount = [];
            var totalDiscountvalue = 0;
            var totalSubtotalValue = 0;


            $('.discountAfterInput').each(function() {
                totalDiscount.push(parseFloat($(this).text()));
            });
            $('.itemTotalPriceTxt').each(function() {
                totalSubtotal.push(parseFloat($(this).text()));
            });

            totalDiscountvalue = totalDiscount.reduce(function(acc, value) {
                return acc + value;
            }, 0);
            totalSubtotalValue = totalSubtotal.reduce(function(acc, value) {
                return acc + value;
            }, 0);

            var discount = parseFloat($('#discountMain').val()) || 0;
            var overallDiscount = totalDiscountvalue + discount;
            var totalProductDiscount = totalDiscountvalue;
            var totalProductSubtotal = totalSubtotalValue;
            var paid = totalProductSubtotal - overallDiscount;

            var total = paid;
            var message = $('#note').val();
            var paidamount = parseFloat($("#paid_amount").val());
            var due = 0;



            var url = "{{ route('pos.updateCalculate') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    discount: discount,
                    overallDiscount: overallDiscount,
                    totalProductDiscount: totalProductDiscount, // Corrected key-value assignment
                    totalProductSubtotal: totalProductSubtotal, // Corrected key-value assignment
                    paid: paid,
                    due: due,
                    total: total,
                    message: message, // Corrected key-value assignment
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {


                    $("#subtotal_text").val(parseFloat(data?.data?.sub_total).toFixed());
                    $("#totalDiscount").val(parseFloat(data?.data?.total_product_discount).toFixed());
                    $("#discountMain").val(parseFloat(data?.data?.discount).toFixed());
                    $("#overallDiscount").val(parseFloat(data?.data?.overall_discount).toFixed());
                    $("#paid_amount").val(parseFloat(data?.data?.paid).toFixed());
                    $("#due_amount").val(parseFloat(data?.data?.due).toFixed());
                    $("#note").val(data?.data?.note);
                    $("#total_text").text(parseFloat(data?.data?.total).toFixed());
                    $("#grandTotal").val(parseFloat(data?.data?.total).toFixed());


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                }
            });



        }





        $(document).on("change", ".quantityInput", function() {
            var productId = $(this).attr('data-id');
            var value = parseFloat($(this).val()) || 0;
            updateQuantity(productId, value);
            // calculate()
        });





        $(document).on("change", ".discountInput", function() {
            var productId = $(this).attr('data-id');
            var value = parseFloat($(this).val()) || 0;


            var url = "{{ route('pos.updateDiscount', '') }}" + "/" + productId;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    value: value, // Corrected key-value assignment
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {

                    afterUpdate(data)
                    calculate()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                }
            });

            // var totalpriceproduct = parseFloat($('.itemTotalPriceTxt[data-id="' + productId + '"]').text()) || 0;

            // var selecttype = $('.discountType[data-id="' + productId + '"]').val();
            // if (selecttype == 'flat') {
            //     flat(productId, value)
            // }

            //  calculate()
        });


        $(document).on("change", ".discountType", function() {
            var id = $(this).attr('data-id');
            var value = $(this).val();


            var url = "{{ route('pos.updateDiscountType', '') }}" + "/" + id;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    value: value, // Corrected key-value assignment
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {

                    afterUpdate(data)
                    calculate()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                }
            });





        })

        $(document).on("change", "#discountMain", function() {

            calculate()
        })
        // $(document).on("change", "#note", function() {

        //     calculate()
        // })


        $(document).on("change", "#paid_amount", function() {
            var value = parseFloat($(this).val()) || 0;
            var totalvalue = parseFloat($("#grandTotal").val()) || 0;
            var afterPaid = totalvalue - value;

            $("#due_amount").val(afterPaid.toFixed());
            $("#total").val()
            // calculate()

        })

        // submit form

        // Assuming you have a form with the id "your-form-id"







        function filter() {
            var search_term = $('#search_term').val();
            var search_term_barcode = $('#search_term_barcode').val();
            var category_id = $('#category_id').val();
            var brand_id = $('#brand_id').val();

            var url = '/admin/pos/get-products?filter=1';
            var search_status = 0;
            if (search_term) {
                if (/\S/.test(search_term)) {
                    search_term = search_term.replace(/^\s+/g, '');
                    search_term = search_term.replace(/\s+$/g, '');
                    url += '&search_term=' + search_term;
                    //alert( '--'+search_term+'--' );
                    search_status = 1;
                }
            }
            if (category_id) {
                url += '&category_id=' + category_id;
                //alert( category_id );
                search_status = 1;
            }
            if (brand_id) {
                url += '&brand_id=' + brand_id;
                //alert( brand_id );
                search_status = 1;
            }

            if (search_status == 0) {
                url = '/admin/pos/get-products';
            }

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {

                    console.log("filterer data", data);

                    var html = '';
                    if (Object.keys(data).length > 0) {
                        $.each(data, function(key, value) {

                            var product_name = value.name_en;

                            product_name = product_name.slice(0, 30) + (product_name.length > 30 ?
                                "..." : "");

                            var price_after_discount = value.regular_price;
                            if (value.discount_type == 1) {
                                price_after_discount = value.regular_price - value.discount_price;
                            } else if (value.discount_type == 2) {
                                price_after_discount = value.regular_price - (value.regular_price *
                                    value.discount_price / 100);
                            }
                            // if(value.is_varient == 1)
                            // {
                            html += `<div class="col-sm-2 col-xs-6 product-thumb product-row-list-template" onclick="addToList(${value.stock_qty > 0 ? value.id : '#'})">
                                            <div class="mb-4 card">
                                                <div class="card-body position-relative">`;
                            if (value.stock_qty <= 0) {
                                html += `<div class="product_stock_out">Stock Out</div>`;
                            }
                            html += `<div class="product-image">`;
                            if (value.product_thumbnail && value.product_thumbnail != '' && value
                                .product_thumbnail != 'Null') {
                                html +=
                                    `<img class="default-img" src="/${value.product_thumbnail}" alt="" />`;
                            } else {
                                html += `<img class="default-img" src="/upload/no_image.jpg" alt="" />`;
                            }
                            html += `</div>
                                                    <p style="font-size: 10px; font-weight: bold; line-height: 15px; height: 30px;">
                                                        ${product_name}
                                                    </p>
                                                    <div>`;

                            html +=
                                `<p style="font-size: 10px; font-weight: bold; line-height: 10px; height: 15px;">
                                                        Model No: ${value.model_number}
                                                    </p>
                                                  `;
                            html +=
                                `<p style="font-size: 10px; font-weight: bold; line-height: 10px; height: 15px;">
                                                        Stock: ${value.stock_qty}
                                                    </p>
                                                    <input type="hidden" id="pv_type_${value.id}" value="0">
                                                    <input type="hidden" id="product_stock_${value.id}" value="${value.stock_qty}">`;
                            html +=
                                `<p style="font-size: 10px; font-weight: bold; line-height: 10px; height: 15px;">
                                                        Purchase Code: ${value.purchase_code}
                                                    </p>
                                                  `;
                            if (value.discount_price > 0) {

                               if (value.discount_type == 1) {
                                   html += `<div class="product-price">
                                                                    <h6 class="price text-primary">৳ ${value.discount_price }</h6>
                                                                    <del class="old-price">৳ ${value.regular_price }</del>
                                                                    <span class="price text-primary">৳ ${price_after_discount }</span>
                                                                </div>`;
                               }
                               else if (value.discount_type == 2){
                                   html += `<div class="product-price">
                                                                    <h6 class="price text-primary"> ${((value.discount_price / 100) * 100)}%</h6>
                                                                    <del class="old-price">৳ ${value.regular_price }</del>
                                                                    <span class="price text-primary">৳ ${price_after_discount }</span>
                                                                </div>`;
                               }
                            } else {
                                html += `<div class="product-price">
                                                                    <span class="price text-primary">৳ ${value.regular_price }</span>
                                                                </div>`;
                            }
                            html += `</div>
                                                </div>
                                            </div>
                                        </div>`;

                        });
                    } else {
                        html = '<div class="text-center"><p>No products found!</p></div>'
                    }
                    $('#product_wrapper').html(html);
                }
            });
            templateproduct()

        };


        function barcode() {
            var barcode_search_term = $('#barcode_search_term').val();
            $.ajax({
                type: 'GET',
                url: '/admin/pos/barcode-product/' + barcode_search_term,
                dataType: 'json',
                success: function(abc) {


                    addToList(abc.id);


                    $('#barcode_search_term').val(null);
                }
            });
        }
    </script>
    <script>
        /* ================ Load More Product show ============ */
        // $(document).(".product-row .product-row-list").hide();
        // $(document).(".product-row .product-row-list").slice(0, 6).show();
        // $(document).("#seemore").click(function() {
        //
        //     $(".product-row .product-row-list:hidden").slice(0, 6).slideDown();
        //     if ($(".product-row .product-row-list:hidden").length == 0) {
        //         $("#load").fadeOut('slow');
        //     }
        // });


        $(document).ready(function() {
            $(".product-row .product-row-list").hide();
            $(".product-row .product-row-list").slice(0, 10).show();
            $("#seemore").click(function() {

                $(".product-row .product-row-list:hidden").slice(0, 10).slideDown();
                if ($(".product-row .product-row-list:hidden").length === 0) {
                    $("#load").fadeOut('slow');
                }
            });
        });

        // template product
        function templateproduct() {
            $(".product-row .product-row-list").hide();
            $(".product-row .product-row-list").slice(0, 10).show();
            $("#seemore").click(function() {

                $(".product-row .product-row-list:hidden").slice(0, 10).slideDown();
                if ($(".product-row .product-row-list:hidden").length === 0) {
                    $("#load").fadeOut('slow');
                }
            });
        }


        $(document).on("click", "#refresh", function() {
            location.reload();
            window.location = "{{ route('pos.index') }}";
            console.log(location.reload())
        });
    </script>
    {{-- scrollBarBottom  --}}
    <script>
        $(document).ready(function() {
            // Scroll to Bottom Function
            $("#scrollToBottomButton").click(function() {
                $("html, body").animate({
                    scrollTop: $(document).height()
                }, "slow");
            });

            // Scroll to Top Function
            $("#scrollToUpButton").click(function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            });
        });
    </script>
    {{-- count wise product show part  --}}
    <script>
        $(document).ready(function() {
            $('#productCountSelector').on('change', function() {
                var selectedCount = $(this).val();
                loadProducts(selectedCount);
            });

            function loadProducts(count) {
                var url = "{{ route('getCountProducts') }}";
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        count: count
                    },
                    success: function(response) {
                        console.log("response", response);
                        displayProducts(response);
                    },
                    error: function(error) {
                        console.error('Error loading products:', error);
                    }
                });
            }

            function displayProducts(Allproducts) {
                $('#product_wrapper').empty();
                for (var i = 0; i < Allproducts.length; i++) {
                    var product = Allproducts[i];
                    var productHtml = '<div class="col-sm-2 col-xs-6 product-thumb product-row-list"';
                    if (product.stock_qty > 0) {
                        productHtml += ' onclick="addToList(' + product.id + ')"';
                    }
                    productHtml += '>';
                    productHtml += '<div class="mb-4 card">';
                    productHtml += '<div class="card-body position-relative">';

                    if (product.stock_qty <= 0) {
                        productHtml += '<div class="product_stock_out">Stock Out</div>';
                    }

                    console.log('product_image rrrr', product.product_thumbnail);

                    productHtml += '<div class="product-image">';
                    if (product.product_thumbnail) {

                        productHtml += '<img class="default-img" src="{{ asset('') }}' + product
                            .product_thumbnail + '" alt="">';
                    } else {

                        productHtml +=
                            '<img class="default-img" src="{{ asset('upload/no_image.jpg') }}" alt="No Image">';
                    }
                    productHtml += '</div>';

                    productHtml +=
                        '<p style="font-size: 10px; font-weight: bold; line-height: 15px; padding-top: 30px;">' +
                        product.name_en + '</p>';
                    productHtml += '<input type="hidden" id="pv_type_' + product.id + '" value="0">';
                    productHtml +=
                        '<p style="font-size: 10px; font-weight: bold; line-height: 10px; padding-top: 0px;">Stock: ' +
                        product.stock_qty + '</p>';

                    productHtml +=
                        '<p style="font-size: 10px; font-weight: bold; line-height: 10px; padding-top: 0px;">Purchase Code: ' +
                        (product.purchase_code || '' )+ '</p>';

                    if (product.model_number !== null) {
                        productHtml +=
                            '<p style="font-size: 10px; font-weight: bold; line-height: 10px; padding-top: 0px;">Model No: ' +
                            (product.model_number || '') + '</p>';
                    }

                    productHtml += '<input type="hidden" id="product_stock_' + product.id + '" value="' + product
                        .stock_qty + '">';

                    productHtml += '<div class="product-price">';

                    if (product.discount_price > 0) {
                        var priceAfterDiscount = (product.discount_type == 1) ? (product.regular_price - product
                            .discount_price) : (product.regular_price - (product.regular_price * product
                            .discount_price) / 100);


                        if (product.discount_type == 1)
                        {
                            productHtml += '<h6 class="price text-danger">off: ৳' + product.discount_price + '</h6>';
                            productHtml += '<del class="old-price">৳' + product.regular_price + '</del>';
                            productHtml += '<span class="price text-primary">৳' + priceAfterDiscount + '</span>';
                        }
                        else if(product.discount_type == 2){
                            productHtml += '<h6 class="price text-danger">off: ' + (((product.discount_price) / 100) * 100)+ '%' + '</h6>';
                            productHtml += '<del class="old-price">৳' + product.regular_price + '</del>';
                            productHtml += '<span class="price text-primary">৳' + priceAfterDiscount + '</span>';
                        }
                    } else {
                        productHtml += '<span class="price text-primary">৳' + product.regular_price + '</span>';
                    }

                    productHtml += '</div>';
                    productHtml += '</div>';
                    productHtml += '</div>';
                    productHtml += '</div>';
                    productHtml += '</div>';

                    $('#product_wrapper').append(productHtml);
                }
            }
        });
    </script>
@endpush
