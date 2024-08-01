@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Order Payment</h2>
            <div>
                <a href="{{ route('manufacture.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>View
                    Order List</a>
            </div>
        </div>
        </div>

        <form action="{{ route('manufacture.paymentStore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                                <input class="form-control" type="text" id="barcodeInput"
                                    placeholder="Scan barcode Here" oninput="">
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12" id="productInfo">

                            {{-- invoice --}}

                            {{-- invoice end --}}

                            {{-- <div id="productInfo" class="mt-4">

                            </div> --}}

                        </div>

                    </div>
                    <div class="row">
                        <input type="hidden" name="collected_by" id="collectId">
                        <input type="hidden" name="worker_id" id="workerId">
                        <input type="hidden" name="product_id" id="productId">
                        <input type="hidden" name="debit" id="Debit">
                        <input type="hidden" name="manupart" id="manupart">
                        <input type="hidden" name="manupartqty" id="manupartqty">
                        <input type="hidden" name="manuId" id="manuId">

                    </div>
                    <div class="row mb-4 justify-content-sm-end">
                        <div class="col-lg-2 col-md-4 col-sm-5 col-6">
                            <input type="submit" class="btn btn-primary" value="Collect Order">
                        </div>
                    </div>
                </div>
                <!-- card-body end// -->
            </div>
        </form>

    </section>

    @push('footer-script')
        <script>
            $(document).ready(function() {

                $('#barcodeInput').change(function() {
                    var value = $(this).val();
                    var url = "{{ route('manufacture.getOrder', '') }}" + "/" + value;

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data)
                            if (data.data == null) {
                                toastr.warning("Order Doesn't Match!");
                            } else {
                                toastr.success("Order Match!");
                                const {
                                    id,
                                    product,
                                    manufacture_quantity,
                                    manufacture_part,
                                    is_complete,
                                    total_price,
                                    manufacture_price,
                                    user
                                } = data.data;
                                let status = is_complete == 1 ? 'completed' : 'pending';
                                var manufactureimage = window.location.origin + "/" + product
                                    .menu_facture_image;
                                var productimage = window.location.origin + "/" + product
                                    .product_thumbnail;

                                var html = `

                                <div class="container mt-4">
                                <div class="card">
                                    <div class="card-header text-white">
                                       Order Info


                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-sm-6">
                                                <h6 class="mb-3">From:</h6>
                                                <div>
                                                    <strong>${user?.name}</strong>
                                                </div>
                                                <div>${user?.address}</div>
                                                <div>Email: ${user?.email}</div>
                                                <div>Phone: ${user?.phone}</div>
                                            </div>

                                        </div>

                                        <div class="table-responsive-sm">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="center">#</th>
                                                        <th>Product Name</th>
                                                        <th>Product Image</th>
                                                        <th>Manufacture Image</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="center">1</td>
                                                        <td class="left strong">${product?.name_en}</td>
                                                        <td class="left"><img src="${productimage}" height="200" width="200"></td>
                                                        <td class="left"><img src="${manufactureimage}" height="200" width="200"></td>



                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-sm-5">

                                            </div>

                                            <div class="col-lg-4 col-sm-5 ">
                                                <table class="table table-clear">
                                                    <tbody>
                                                        <tr>
                                                            <td class="left">
                                                                <strong>Manufacture QTY</strong>
                                                            </td>
                                                            <td class="right">${manufacture_quantity}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="left">
                                                                <strong>Manufacture Price</strong>
                                                            </td>
                                                            <td class="right">${manufacture_price}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="left">
                                                                <strong>Total Price</strong>
                                                            </td>
                                                            <td class="right">${total_price}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>








                            </div>

                                `;
                            }
                            $('#productInfo').html(html);
                            $('#total_amount').val(data.data.total_price);
                            $("#manufacture_id").val(data.data.id);
                            $("#productId").val(data.data.product.id);
                            $("#workerId").val(data.data.user_id);
                            $("#collectId").val(data.data.user_id);
                            $("#Debit").val(data.data.total_price);
                            $("#manupart").val(data.data.manufacture_part);
                            $("#manupartqty").val(data.data.manufacture_quantity);
                            $("#manuId").val(data.data.id);



                        },
                    });
                });



                $("#paid_amount").keyup(function() {
                    var value = parseFloat($(this).val()) || 0;
                    var totalAmount = parseFloat($('#total_amount').val()) || 0;
                    var dueAmount = totalAmount - value;
                    console.log(value)
                    console.log(dueAmount)
                    if (dueAmount < 0) {
                        console.log('bd')
                        $("#due_amount").val(0);
                    } else {
                        $("#due_amount").val(dueAmount);
                    }

                })
            })
        </script>
    @endpush
@endsection
