@extends('admin.admin_master')
@section('admin')
    @push('css')
        <style>
            .product {
                margin: 10px;
                padding: 10px;
                transition: transform 0.3s ease;
            }

            .product:hover {
                transform: scale(1.1);
                cursor: pointer;
            }

            .product.selected {
                border-color: blue;
                box-shadow: 0 0 10px 0 blue;
            }

            .create_card {}

            .create_card .pagination {}

            .create_card .page-link {
                padding: 8px 18px;
                font-size: 16px;
                font-weight: 600;
                color: black;
            }

            .create_card .page-item.active .page-link {
                z-index: 3;
                color: #fff;
                background-color: #3bb77e;
                border-color: #3bb77e;
            }

            .create_card .manufac__product {
                height: 100%;
                justify-content: center;
            }


            .manufac__product .image img {
                width: 100%;
                display: block;
                height: auto;
            }

            .manufac__product .manuproduct__name h5 {
                font-size: 16px;
                font-weight: 600;
            }
        </style>
    @endpush
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Create Manufacture Order</h2>
            <div class="">
                <a href="{{ route('manufacture.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>
                    Product List</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mx-auto card">
                <!-- form -->

                <div class="row"></div>
                <div class="row mainRow">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <div class="d-flex">
                            <div class="input-group width-100" style="width: 100%">
                                <input type="text" class="form-control productSearch" name="search" placeholder="search"
                                    value="{{ request('search') }}">
                            </div>
                            <button type="submit" data-toggle="tooltip" data-placement="top" title="Search"
                                class="btn btn-sm btn-yellow"
                                style="width: 40px; border-top-left-radius: 2px; border-bottom-left-radius: 2px; background-color: #29A56C; color:white"><i
                                    class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- <form method="GET" class="px-3 mt-30 mb-3">
                    <div class="row"></div>
                    <div class="row">
                        <div class="col-md-8 col-lg-6 col-xl-4">
                            <div class="d-flex">
                                <div class="input-group width-100" style="width: 100%">
                                    <input type="text" class="form-control" name="search" placeholder="search"
                                        value="{{ request('search') }}">
                                </div>
                                <button type="submit" data-toggle="tooltip" data-placement="top" title="Search"
                                    class="btn btn-sm btn-yellow"
                                    style="width: 40px; border-top-left-radius: 2px; border-bottom-left-radius: 2px; background-color: #29A56C; color:white"><i
                                        class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form> --}}

                <!-- form -->
                <form method="post" action="{{ route('manufacture.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="create_card">
                        <div class="card-body productCardBody">
                            {{-- search field --}}
                            {{-- @dd($products); --}}
                            <div class="row gy-4 align-items-stretch " id="productForForeach">
                                @foreach ($products as $key => $product)
                                    <div class="product selectedProduct col-6 col-lg-4 col-xl-3 col-xxl-2" id="{{ $product->id }}">
                                        <input type="hidden">
                                        <div class="card manufac__product p-3">
                                            <div class="">
                                                <div class="mt-2">
                                                    <div class="image">
                                                        @if ($product->menu_facture_image)
                                                            <img src="{{ asset($product->menu_facture_image) }}"
                                                                class="img-sm" alt="Userpic">
                                                        @else
                                                            <img class="img-lg mb-3"
                                                                src="{{ asset('upload/no_image.jpg') }}" alt="Userpic" />
                                                        @endif
                                                    </div>
                                                    <div class="mt-5 text-center manuproduct__name">
                                                        <h5 class="text-uppercase mb-0">{{ $product->name_en }}</h5>

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="text-center mt-2 mb-2">
                                                <span>Available Stock: {{ $product->stock_qty }}</span>
                                                <div class="colors">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>

                                            </div>
                                            {{-- <button class="btn btn-danger">Add to cart</button> --}}
                                        </div>
                                    </div>
                                @endforeach

                                <div>
                                    <!-- Display pagination links here -->
                                    {{ $products->links() }}
                                </div>
                            </div>
                            <div id="mypager"></div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 md-4">
                                    <label for="Product">Product Name</label>
                                    <input type="hidden" class="form-control productValue" name="product_id"
                                        value="{{ old('product_id') }}">
                                    <input type="text" class="form-control productValueText" readonly
                                        value="Product Name">
                                    @error('product_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6 md-4">
                                    <div class="custom_select">
                                        <label for="">Select Part</label>
                                        <select class="form-control select-active w-100 form-select select-nice selectPart"
                                            name="manufacture_part" id="manufacturePart">
                                            <option selected disabled value="">--Select Part--</option>
                                            <option value="body-part">Body Part</option>
                                            <option value="finishing-part">Finishing Part</option>
                                        </select>
                                        @error('manufacture_part')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 md-4 mt-4">
                                    <div class="custom_select">
                                        <label for="">Select Worker</label>
                                        <select
                                            class="form-control select-active w-100 form-select select-nice selectWorker"
                                            name="user_id">
                                            <option disabled readonly selected value="">--Select Workers--</option>

                                        </select>
                                        @error('user_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4 mt-2">
                                    <label for="product_stock" class="col-form-label" style="font-weight: bold;">Product
                                        Stock: </label>
                                    <input class="form-control" id="product_stock" type="text" readonly value=""
                                        placeholder="Stock Product">
                                    @error('user_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="manufacture_price" class="col-form-label" style="font-weight: bold;"><span
                                            class="manufacturePartText"></span>
                                        price:</label>
                                    <input class="form-control" id="manufacture_price" type="text" readonly
                                        name="manufacture_price" placeholder="manufacture price"
                                        value="{{ old('manufacture_price') }}">
                                    @error('manufacture_price')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="" class="form-label">Customer Name</label>
                                    <input type="text" name="customer_name" class="form-control" placeholder="Customer Name">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4 ">
                                    <label for="manufacture_quantity" class="col-form-label"
                                        style="font-weight: bold;">Manufacture Quantity:</label>
                                    <input class="form-control" id="manufacture_quantity" type="number"
                                        name="manufacture_quantity" placeholder="manufacture quantity"
                                        value="{{ old('manufacture_quantity') }}">
                                    @error('manufacture_quantity')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="total_price" class="col-form-label" style="font-weight: bold;">Total
                                        Price:</label>
                                    <input class="form-control" id="total_price" type="number" name="total_price"
                                        placeholder="Total Price" readonly value="{{ old('total_price') }}">
                                </div>
                                <div>
                                    <label for="note">Note</label>
                                    <textarea name="note" class="form-control" id="note" cols="30" rows="10"></textarea>
                                </div>
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="form-check-input me-2 cursor" name="is_confirm"
                                        id="is_confirm" value="1">
                                    <label class="form-check-label cursor" for="is_confirm">Is Confirm</label>
                                </div>


                            </div>

                        </div>
                    </div>
                    <div class="row mb-4 justify-content-sm-end">
                        <div class="col-lg-2 col-md-4 col-sm-5 col-6">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection


@push('footer-script')
    <script>
        document.querySelectorAll('.product').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.product').forEach(item => {
                    item.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });


        $(document).ready(function() {
            $('.selectPart').prop("disabled", true);
            // $('#manufacture_quantity').prop("disabled", true)
            $(document).on("click", '.selectedProduct', function() {
                var productId = $(this).attr('id');
                // console.log(productId)
                $('.productValue').val(productId)
                $('.selectPart').prop("disabled", false);
                var url = "{{ route('GetProductId', '') }}" + "/" + productId;

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        // console.log(response)
                        $('.selectedpart').data('id', response.id);
                        $('.productValueText').val(response.name_en);
                        $('#product_stock').val(response.stock_qty);
                    }
                });
            });

            $(document).on("change", '.selectPart', function() {
                var part = $(this).val();
                console.log(part)
                var selectWorker = $('.selectWorker');
                var url = "{{ route('GetWorkerManufacture') }}";
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        menufacturePart: part,
                        _token: '{{ csrf_token() }}'

                    },
                    success: function(response) {
                        console.log(response)
                        selectWorker.empty();

                        $.each(response.data, function(key, value) {
                            console.log(value)
                            selectWorker.append($('<option>', {
                                value: value.user_id,
                                text: value.name
                            }));
                        });
                        getProductRate();
                    }
                });
            })

            // $('.selectWorker').change(function() {
            //     var id = $(this).val();
            //     // console.log(id)
            //     $('#manufacture_quantity').prop("disabled", false)
            //     getProductRate();
            //     var url = "{{ route('GetWorkerManufacture', '') }}" + "/" + id;
            //     $.ajax({
            //         url: url,
            //         method: 'GET',
            //         success: function(response) {
            //             console.log(response)
            //             $('#manufacturePart').val(response.data.manufacture_part);
            //             getProductRate();
            //         }
            //     });
            // })

            function getProductRate() {
                var productId = $('.productValue').val();
                var manufacturePart = $('#manufacturePart').val();
                var url = "{{ route('GetProductOrder', '') }}" + "/" + productId;
                console.log("manufacture Part", manufacturePart)
                // console.log("product rate", productId)

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        // console.log(response);
                        if (manufacturePart == 'body-part') {
                            $('.manufacturePartText').text('Body Part')
                            $('#manufacture_price').val(response.data.body_rate)
                        } else if (manufacturePart == 'finishing-part') {
                            $('.manufacturePartText').text('Finishing Part')
                            $('#manufacture_price').val(response.data.finishing_rate)
                        }

                    }
                });
            }

            $(document).on("change", '#manufacture_quantity', function() {
                var value = parseFloat($(this).val());
                var manufacturePrice = parseFloat($('#manufacture_price').val());
                var total = manufacturePrice * value;
                $('#total_price').val(total);
                // console.log(value)
                // console.log(manufacturePrice)
                // console.log(total)
            })
        });


        function fetchProduct(data) {
            var items = data?.data?.products;
            console.log("items", items)


            if (!items.length > 0) {
                $('#productForForeach').empty();
                $('#productForForeach').html(`<div class="text-center pt-10 pb-10" id="no_product_text">
                                                <span>No Product Added</span>
                                            </div>`);


            } else {
                var results = '';
                for (var i = 0; i < items.length; i++) {
                    var singledata = items[i];
                    var htmlItem = `
                    <div class="selectedProduct col-6 col-lg-4 col-xl-3 col-xxl-2" id="${singledata?.id}">
                                        <input type="hidden">
                                        <div class="card manufac__product p-3">
                                            <div class="">
                                                <div class="mt-2">
                                                    <div class="image">
                                                            <img src="${window.location.origin}/${singledata.menu_facture_image ? singledata.menu_facture_image: 'upload/no_image.jpg' }"
                                                                class="img-sm" alt="Userpic">
                                                    </div>
                                                    <div class="mt-5 text-center manuproduct__name">
                                                        <h5 class="text-uppercase mb-0">${singledata?.name_en}</h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-center mt-2 mb-2">
                                                <span>Available Stock: ${singledata?.stock_qty}</span>
                                                <div class="colors">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>

                                            </div>
                                            {{-- <button class="btn btn-danger">Add to cart</button> --}}
                                        </div>
                                    </div>
                    `;
                    results += htmlItem;
                }
                $('#productForForeach').empty();
                $('#productForForeach').html(results);


                $('#paginationLinks').html(`<button>Load More</button>`);

            }

        }




        $('.mainRow').on("keyup", ".productSearch", function() {
            var value = $(this).val();
            console.log("input value", value)
            var url = "{{ route('manufacture.search.product') }}";
            // var url = "{{ route('manufacture.create') }}";
            console.log("first url", url)
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    search: value,
                    _token: '{{ csrf_token() }}'

                },
                success: function(response) {
                    console.log(response?.data?.products?.links);
                    console.log("response", response)
                    fetchProduct(response)


                }
            });
        })
    </script>
@endpush
