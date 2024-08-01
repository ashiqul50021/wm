@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @push('css')
        <style>
            .form-control,
            .form-select {
                border: 1px solid #4f5d77 !important;
                padding-left: 10px !important;
            }
        </style>
    @endpush
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Manufacturing Images <span class="badge rounded-pill alert-success">
                    {{ count($products) }} </span></h2>
        </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Name (English)</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Menufacture Image</th>
                                <th scope="col">Variant Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Parts</th>
                                <th scope="col">Staff</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td> {{ $product->name_en ?? 'NULL' }} </td>
                                    <td>
                                        <img src="{{ asset($product->product_thumbnail) }}" class="img-sm" id="print-image"
                                            alt="Not image found" style="width: 80px; height: 70px;">
                                    </td>
                                    <td>
                                        <a href="{{ route('menufacturing.print', $product->id) }}" target="_blank"
                                            class="itemside">
                                            <div class="left">
                                                <img src="{{ asset($product->menu_facture_image) }}" class="img-sm"
                                                    id="print-image" alt="Not image found"
                                                    style="width: 80px; height: 70px;">
                                            </div>
                                        </a>
                                    </td>
                                    <td>{{ $product->variant_name }}</td>
                                    @if ($product->productMenufacture)
                                        <td>
                                            <input type="text" name="manu_qty" id="getQty{{ $product->id }}"
                                                onchange="sendQty({{ $product->id }})" placeholder="Quantity"
                                                value="{{ $product->productMenufacture->menufacture_quantity }}">
                                        </td>
                                    @else
                                        <td>
                                            <input type="text" name="manu_qty" id="getQty{{ $product->id }}"
                                                onchange="sendQty({{ $product->id }})" placeholder="Quantity"
                                                value="0">
                                        </td>
                                    @endif

                                    <td>
                                        <form>
                                            @if ($product->productMenufacture)
                                                <label class="radio-inline"><input type="radio" name="optradio"
                                                        id="Body_Parts" @if ($product->productMenufacture->body_part_varcode > 0) checked @endif
                                                        onclick="selectType('Body-Parts',{{ $product->id }})">&nbsp; Body
                                                    Parts</label>&nbsp;

                                                <label class="radio-inline"><input type="radio" name="optradio"
                                                        id="Finishing_Parts"
                                                        @if ($product->productMenufacture->finishing_part_varcode > 0) checked @endif
                                                        onclick="selectType('Finishing-Parts',{{ $product->id }})">&nbsp;
                                                    Finishing Parts</label>
                                            @else
                                                <label class="radio-inline"><input type="radio" name="optradio"
                                                        id="Body_Parts"
                                                        onclick="selectType('Body-Parts',{{ $product->id }})">&nbsp; Body
                                                    Parts</label>&nbsp;

                                                <label class="radio-inline"><input type="radio" name="optradio"
                                                        id="Finishing_Parts"
                                                        onclick="selectType('Finishing-Parts',{{ $product->id }})">&nbsp;
                                                    Finishing Parts</label>
                                            @endif

                                        </form>
                                    </td>
                                    <td>
                                        @if ($product->productMenufacture)
                                            <select name="staff_id" class="form-control select-active w-100 form-select"
                                                id="staff_id{{ $product->id }}"
                                                onchange="sendStaff({{ $product->id }})">
                                                <option value='0'>-- Assaign By --</option>
                                                @foreach ($staffs as $staff)
                                                    <option @if ($product->productMenufacture->user_id == $staff->user_id) selected @endif
                                                        value="{{ $staff->id }}">{{ $staff->user->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <select name="staff_id" class="form-control select-active w-100 form-select"
                                                id="staff_id{{ $product->id }}"
                                                onchange="sendStaff({{ $product->id }})">
                                                <option value='0'>-- Assaign By --</option>
                                                @foreach ($staffs as $staff)
                                                    <option value="{{ $staff->id }}">{{ $staff->user->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- table-responsive //end -->
            </div>
            <!-- card-body end// -->
        </div>
    </section>
@endsection

@push('footer-script')
    <script>
        $(document).ready(function() {
            $('.print-image').on('click', function() {
                var imageSrc = $(this).data('src');
                var printWindow = window.open('', '_blank');
                printWindow.document.write('<html><head><title>Print Image</title></head><body><img src="' +
                    imageSrc + '" onload="window.print();" /></body></html>');
                printWindow.document.close();
            });
        });
    </script>

    <script>
        function sendQty(id) {
            let manu_qty = '';
            let menu_qty_input = document.getElementById('getQty' + id).value;
            if (menu_qty_input === '') {
                manu_qty = 0;
            } else {
                manu_qty = parseInt(menu_qty_input); // Convert input to integer
            }
            console.log(manu_qty);
            $.ajax({
                type: "get",
                url: "{{ url('/admin/product/save-qty/') }}/" + id + "/" + manu_qty,
                success: function(response) {
                    //console.log(response)
                    $("#getQty").val(manu_qty)
                }
            });
        }
    </script>

    <script>
        function sendStaff(id) {
            const staff_id = document.getElementById('staff_id' + id).value;
            $.ajax({
                type: "get",
                url: "{{ url('/admin/product/save-staff/') }}/" + staff_id + "/" + id,
                success: function(response) {
                    // console.log(response)
                    $("#staff_id" + id).val(staff_id)
                }
            });
        }
    </script>

    <script>
        function selectType(type, id) {

            updateBody(type, id);

            $.ajax({
                type: "get",
                url: "{{ url('/admin/product/menufacturing-image/type/') }}/" + type,
                success: function(response) {
                    $("#staff_id" + id).html(response);

                    // updateBody()
                }
            });
        }


        function updateBody(type, id) {
            if (type === 'Body-Parts') {
                // console.log('hello body', id)
            } else if (type === 'Finishing-Parts') {
                // console.log('hello finishing',id)
            }
            var url = "{{ route('menufacturingImageBarcode') }}";
            console.log(url)
            $.ajax({
                type: "get",
                url: url,
                data: {
                    type: type,
                    id: id,
                },
                success: function(response) {
                    console.log(response)
                }
            });
        }
    </script>
@endpush
