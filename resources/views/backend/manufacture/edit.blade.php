@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Edit Manufacture Order</h2>
            <div class="">
                <a href="{{ route('manufacture.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>
                    Product List</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mx-auto">
                <form method="post" action="{{ route('manufacture.update', $manufacture->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-header">
                            <h3>Basic Info</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 md-4">
                                    <div class="custom_select">
                                        <select
                                            class="form-control select-active w-100 form-select select-nice selectedProduct"
                                            name="product_id" id="product_category">
                                            <option disabled hidden {{ old('product_id') ? '' : 'selected' }} readonly
                                                value="">--Select Product--</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ old('product_id', $manufacture->product_id) == $product->id ? 'selected' : '' }}>
                                                    {{ $product->name_en }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 md-4">
                                    <div class="custom_select">
                                        <select
                                            class="form-control select-active w-100 form-select select-nice selectWorker"
                                            name="user_id" id="user_id">
                                            <option disabled hidden {{ old('user_id') ? '' : 'selected' }} readonly
                                                value="">--Select Workers--</option>
                                            @foreach ($workers as $worker)
                                                <option value="{{ $worker->id }}"
                                                    {{ old('user_id', $manufacture->user_id) == $worker->id ? 'selected' : '' }}>
                                                    {{ $worker->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 md-4 mt-4">
                                    <div class="custom_select">
                                        <select
                                            class="form-control select-active w-100 form-select select-nice selectedpart"
                                            name="manufacture_part" id="manufacture_part">
                                            <option selected disabled value="">--Select Part--</option>
                                            <option value="body-part" @if ($manufacture->manufacture_part == 'body-part') selected @endif>Body
                                                Part</option>
                                            <option value="finishing-part"
                                                @if ($manufacture->manufacture_part == 'finishing-part') selected @endif>Finishing Part</option>
                                        </select>
                                        @error('product_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 mt-2">
                                    <label for="product_stock" class="col-form-label" style="font-weight: bold;">Product
                                        Stock: </label>
                                    <input class="form-control" id="product_stock" type="text" readonly value=""
                                        placeholder="Stock Product">
                                    @error('name_en')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="manufacture_price" class="col-form-label" style="font-weight: bold;"><span
                                            class="manufacturePartText"></span> price:</label>
                                    <input class="form-control" id="manufacture_price" type="text" readonly
                                        name="manufacture_price" placeholder="manufacture price"
                                        value="{{ old('manufacture_price') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4 ">
                                    <label for="manufacture_quantity" class="col-form-label"
                                        style="font-weight: bold;">Manufacture Quantity:</label>
                                    <input class="form-control" id="manufacture_quantity" type="number"
                                        name="manufacture_quantity" placeholder="manufacture quantity"
                                        value="{{ old('manufacture_quantity') }}">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="total_price" class="col-form-label" style="font-weight: bold;">Total
                                        Price:</label>
                                    <input class="form-control" id="total_price" type="number" name="total_price"
                                        placeholder="Total Price" readonly value="{{ old('total_price') }}">
                                </div>
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="form-check-input me-2 cursor" name="is_confirm"
                                        id="is_confirm" value="1">
                                    <label class="form-check-label cursor" for="is_confirm">Is Confirm</label>
                                </div>


                            </div>

                        </div>
                        <!-- card body .// -->
                    </div>
                    <!-- card .// -->


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
        $(document).ready(function() {
            $('.selectedpart').prop("disabled", true);
            $('.selectWorker').prop("disabled", true);
            $('#manufacture_quantity').prop("disabled", true)
            $('.selectedProduct').change(function() {
                var productId = $(this).val();
                $('.selectedpart').prop("disabled", false);
                $('.selectWorker').prop("disabled", false);
                var url = "{{ route('GetProductId', '') }}" + "/" + productId;
                console.log(url)
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        console.log(response)
                        $('.selectedpart').data('id', response.id);
                    }
                });
            });


            $('.selectedpart').change(function() {
                var value = $(this).val();
                var id = $(this).data('id');
                console.log(id)
                console.log(value)
                $('#manufacture_quantity').prop("disabled", false)

                var url = "{{ route('GetProductOrder', '') }}" + "/" + id;
                console.log(url)
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        $('#product_stock').val(response.data.stock_qty);
                        if (value == 'body-part') {
                            $('.manufacturePartText').text('Body Part')
                            $('#manufacture_price').val(response.data.body_rate)
                        } else if (value == 'finishing-part') {
                            $('.manufacturePartText').text('Finishing Part')
                            $('#manufacture_price').val(response.data.finishing_rate)
                        }

                    }
                });
            })


            $('#manufacture_quantity').change(function() {
                var value = parseFloat($(this).val());
                var manufacturePrice = parseFloat($('#manufacture_price').val());
                var total = manufacturePrice * value;
                $('#total_price').val(total);
                console.log(value)
                console.log(manufacturePrice)
                console.log(total)
            })
        });
    </script>
@endpush
