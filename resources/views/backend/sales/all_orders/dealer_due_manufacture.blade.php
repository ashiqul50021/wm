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

        </div>
        <div class="card">
            <div class="p-2">
                <h4>Assign Worker</h4>
            </div>
            <!-- card-header end// -->
            <div class="card-body">
                <h5>Product Info</h5>
                <div class="row">

                    <div class="col-md-6">
                        <p style="font: bold">Product Image</p>
                        <img src="{{ asset($dueManufacture->product->product_thumbnail ?? '') }}" height="200"
                            width="200" alt="">
                    </div>
                    <div class="col-md-6">
                        <p style="font: bold">Manufacture Image</p>
                        <img src="{{ asset($dueManufacture->product->menu_facture_image ?? '') }}" height="200"
                            width="200" alt="">
                    </div>


                    <table class="table">
                        <thead>
                            <tr>
                                <th>Particular</th>
                                <th>Properties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Product Name</td>
                                <td>{{ $dueManufacture->product->name_en ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Product Quantity</td>
                                <td>{{ $dueManufacture->qty ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Product Price</td>
                                <td>{{ $dueManufacture->unit_price ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Body Rate</td>
                                <td>{{ $dueManufacture->product->body_rate ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Finishing Rate</td>
                                <td>{{ $dueManufacture->product->finishing_rate ?? '' }}</td>

                            </tr>
                            <tr>
                                <td>Product Stock</td>
                                <td>{{ $dueManufacture->product->stock_qty ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <!-- row // -->
                <form action="{{ route('manufacture.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" id="ProductId" value="{{ $dueManufacture->product->id ?? '' }}">
                    {{-- @dd($dueManufacture->id); --}}
                    <input type="hidden" name="due_manufacture_id" value="{{ $dueManufacture->id ?? ''}}">
                    <div class="row">
                        <div class="col-md-6 md-4">
                            <div class="custom_select">
                                <label for="">Select Part</label>
                                <select class="form-control select-active w-100 form-select select-nice selectPart"
                                    name="manufacture_part" id="manufacturePart">
                                    <option selected disabled value="">--Select Part--</option>
                                    <option value="body-part">Body Part</option>
                                    <option value="finishing-part">Finishing Part</option>
                                </select>
                                @error('user_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 md-4 mt-4">
                            <div class="custom_select">
                                <label for="">Select Worker</label>
                                <select class="form-control select-active w-100 form-select select-nice selectWorker"
                                    name="user_id">
                                    <option disabled readonly selected value="">--Select Workers--</option>

                                </select>
                                @error('user_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="manufacture_price" class="col-form-label" style="font-weight: bold;"><span
                                    class="manufacturePartText"></span>
                                price:</label>
                            <input class="form-control" id="manufacture_price" type="text" readonly
                                name="manufacture_price" placeholder="manufacture price"
                                value="{{ old('manufacture_price') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4 ">
                            <label for="manufacture_quantity" class="col-form-label" style="font-weight: bold;">Manufacture
                                Quantity:</label>
                            <input class="form-control" id="manufacture_quantity" type="number" name="manufacture_quantity"
                                placeholder="manufacture quantity"
                                value="{{ old('manufacture_quantity', $dueManufacture->qty ?? '') }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="total_price" class="col-form-label" style="font-weight: bold;">Total
                                Price:</label>
                            <input class="form-control" id="total_price" type="number" name="total_price"
                                placeholder="Total Price" readonly value="{{ old('total_price') }}">
                        </div>
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="form-check-input me-2 cursor" name="is_confirm" id="is_confirm"
                                value="1">
                            <label class="form-check-label cursor" for="is_confirm">Is Confirm</label>
                        </div>

                        <input type="hidden" name="dealer_name" value="{{ $dueManufacture->user->name ?? '' }}">

                        <div>
                            <label for="" name="note" class="form-label">Note:</label>
                            <textarea name="note" id="" cols="30" rows="10" class="form-control mb-3"></textarea>
                        </div>

                    </div>


                    <div class="row mb-4 justify-content-sm-end">
                        <div class="col-lg-2 col-md-4 col-sm-5 col-6">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </div>
                </form>

            </div>
            <!-- card-body end// -->
        </div>
        <!-- card end// -->
    </section>
@endsection
@push('footer-script')
    <script>
        $(document).ready(function() {

            // $('#manufacture_quantity').prop("disabled", true)


            $('.selectPart').change(function() {
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
                var productId = $('#ProductId').val();
                var manufacturePart = $('#manufacturePart').val();
                var url = "{{ route('GetProductOrder', '') }}" + "/" + productId;
                console.log("manufacture Part", manufacturePart)
                // console.log("product rate", productId)

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        // console.log(response);
                        var quantity = $('#manufacture_quantity').val();
                        if (manufacturePart == 'body-part') {
                            $('.manufacturePartText').text('Body Part')
                            $('#manufacture_price').val(response.data.body_rate)
                            var total = quantity * response.data.body_rate;
                            $('#total_price').val(total);
                        } else if (manufacturePart == 'finishing-part') {
                            $('.manufacturePartText').text('Finishing Part')
                            $('#manufacture_price').val(response.data.finishing_rate)
                            var total = quantity * response.data.finishing_rate;
                            $('#total_price').val(total);
                        }

                    }
                });
            }

            $('#manufacture_quantity').keyup(function() {
                var value = parseFloat($(this).val());
                var manufacturePrice = parseFloat($('#manufacture_price').val());
                var total = manufacturePrice * value;
                $('#total_price').val(total);
                // console.log(value)
                // console.log(manufacturePrice)
                // console.log(total)
            })
            $('#manufacture_quantity').change(function() {
                var value = parseFloat($(this).val());
                var manufacturePrice = parseFloat($('#manufacture_price').val());
                var total = manufacturePrice * value;
                $('#total_price').val(total);
                // console.log(value)
                // console.log(manufacturePrice)
                // console.log(total)
            })
        });
    </script>
@endpush
