@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Body Part Order List <span class="badge rounded-pill alert-success">
                    @if (!empty($bodyorders))
                        {{ count($bodyorders) }}
                    @endif
                </span></h2>
            <div>
                {{-- <a href="{{ route('manufacture.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Add
                    Product</a>
                <a href="{{ route('manufacture.orderPayment') }}" class="btn btn-primary"><i
                        class="material-icons md-plus"></i>Order Payment</a> --}}
            </div>
        </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Manufacture Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Worker Name</th>
                                <!--<th scope="col">Product Price </th>-->
                                <th scope="col">Quantity</th>
                                <th scope="col">Manufacture Part</th>
                                <th scope="col">Manufacture Price</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Date</th>
                                <th scope="col">Manufacture Status</th>
                                <th scope="col">Assign part</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($bodyorders->count() > 0)
                                @foreach ($bodyorders as $key => $item)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td width="8%">
                                            <a href="#" class="itemside">
                                                <div class="left">
                                                    @if ($item->product->product_thumbnail)
                                                        <img src="{{ asset($item->product->product_thumbnail) }}"
                                                            class="img-sm" alt="Userpic"
                                                            style="width: 80px; height: 70px;">
                                                    @else
                                                        <img class="img-lg mb-3" src="{{ asset('upload/no_image.jpg') }}"
                                                            alt="Userpic" style="width: 80px; height: 70px;" />
                                                    @endif
                                                </div>
                                            </a>
                                        </td>
                                        <td width="8%">
                                            <a href="{{ route('manufacture.printOrder', $item->id) }}" target="_blank"
                                                class="itemside">
                                                <div class="left">
                                                    @if ($item->product->menu_facture_image)
                                                        <img src="{{ asset($item->product->menu_facture_image) }}"
                                                            class="img-sm" alt="Userpic"
                                                            style="width: 80px; height: 70px;">
                                                    @else
                                                        <img class="img-lg mb-3" src="{{ asset('upload/no_image.jpg') }}"
                                                            alt="Userpic" style="width: 80px; height: 70px;" />
                                                    @endif
                                                </div>
                                            </a>
                                        </td>
                                        <td> {{ $item->product->name_en ?? 'NULL' }} </td>
                                        <td> {{ $item->user->name ?? 'NULL' }} </td>
                                        <td> {{ $item->manufacture_quantity ?? 'NULL' }} </td>
                                        <td> {{ $item->manufacture_part }} </td>
                                        <td> {{ $item->manufacture_price }} </td>
                                        <td> {{ $item->total_price }} </td>
                                        {{-- <td>

                                            <div class="form-check form-switch">
                                                <input class="form-check-input flexSwitchCheckDefault" type="checkbox" data-id={{ $item->id }}
                                                   @if ($item->is_confirm == 1)
                                                    checked
                                                    @endif>
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckDefault">Confirmation</label>
                                            </div>
                                        </td> --}}
                                        <td>
                                            {{$item->updated_at->format('Y-m-d')}}
                                        </td>
                                        <td>
                                            @if ($item->is_complete == 1)
                                                <span class="badge rounded-pill alert-success">Completed</span>
                                                <span>Order by: {{ $item->userOrderBy->name ?? '' }}</span>
                                                <span>Collected by: {{ $item->userOrderBy->name ?? '' }}</span>
                                            @else
                                                <span class="badge rounded-pill alert-warning">Pending</span><br>
                                                <span>Order by: {{ $item->userOrderBy->name ?? '' }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#myModal"
                                                @if ($item->is_complete == 0) disabled
                                                @else
                                                  enabled @endif
                                                onclick="orderFinishing({{ $item->id }})">Finishing Part</button>
                                        </td>

                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" data-bs-toggle="dropdown"
                                                    class="btn btn-light rounded btn-sm font-sm"> <i
                                                        class="material-icons md-more_horiz"></i> </a>
                                                <div class="dropdown-menu">
                                                    {{-- <a class="dropdown-item" href="{{ route('manufacture.edit', $item->id) }}">Edit
                                                info</a> --}}
                                                    {{-- <a class="dropdown-item" href="{{ route('manufacture.printOrder', $item->id) }}">Print Order</a> --}}

                                                    @if (Auth::guard('admin')->user()->role == '2')
                                                        <a class="dropdown-item text-danger"
                                                            href="{{ route('product.delete', $item->id) }}"
                                                            id="delete">Delete</a>
                                                    @else
                                                        @if (Auth::guard('admin')->user()->role == '1' ||
                                                                in_array('4', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                                                            <a class="dropdown-item text-danger"
                                                                href="{{ route('manufacture.delete', $item->id) }}"
                                                                id="delete">Delete</a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- dropdown //end -->
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <p class="text-center">no data found</p>
                            @endif

                        </tbody>
                    </table>
                </div>
                <!-- table-responsive //end -->
            </div>
            <!-- card-body end// -->
        </div>
    </section>


    {{-- modal for create order  --}}
    <!-- Modal HTML -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Finsihing Part Order</h4>
                </div>
                <div class="modal-body">
                    <form id="modalForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <img src="" id="thumbnailImage" alt="" width="200" height="200">
                            <img src="" id="manufactureImage" alt="" width="200" height="200">
                        </div>
                        <div class="form-group mt-2">
                            <p>Product Name : <span id="productNameText"></span></p>
                            <input type="hidden" class="form-control" name="product_id" id="productName"
                                value="">
                        </div>
                        <div class="form-group">
                            <label for="manufacturePart" class="control-label">Manufacture Part:</label>
                            <input type="text" class="form-control" readonly name="manufacture_part"
                                id="manufacturePart" value="finishing-part">
                        </div>
                        <div class="form-group mt-5">

                            <label for="workerAll" class="control-label">Select Worker</label>
                            <select name="user_id" id="workerAll" class="form-select">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="manufacturePart" class="control-label">Manufacture Price:</label>
                            <input type="text" class="form-control" name="manufacture_price" id="manufacturePrice"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="manufacturePart" class="control-label">Manufacture Quantity:</label>
                            <input type="text" class="form-control" readonly name="manufacture_quantity"
                                id="manufactureQuantity" value="">
                        </div>
                        <div class="form-group">
                            <label for="manufacturePart" class="control-label">Total Price:</label>
                            <input type="text" class="form-control" readonly name="total_price" id="totalPrice">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Message:</label>
                            <textarea class="form-control" name="message" id="message-text"></textarea>
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
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <script>
        $(document).ready(function() {
            $('.flexSwitchCheckDefault').change(function() {
                var id = $(this).attr('data-id');
                var url = "{{ route('manufacture.confirmOrder', '') }}" + "/" + id;
                var value = 0;
                console.log(id)
                console.log(url)
                if (this.checked) {
                    value = 1;
                    console.log("Checkbox checked", value);
                } else {
                    value = 0;
                    console.log("Checkbox unchecked", value);
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        value: value,
                        _token: '{{ csrf_token() }}'

                    },
                    success: function(response) {
                        // Handle the response here
                        console.log(response)
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                    }
                });



            })
        })






        // finishing part onclick
        function orderFinishing(id) {
            $("#myModal").modal('show');
            $("#recipient-name").val(id);


            var url = "{{ route('manufacture.getManufactureByid', '') }}" + "/" + id;
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    console.log(response)
                    var thumbnailImage = window.origin + '/' + response?.manufactureOrder?.product
                        ?.product_thumbnail;
                    var manufactureImage = window.origin + '/' + response?.manufactureOrder?.product
                        ?.menu_facture_image;

                    $('#thumbnailImage').attr('src', thumbnailImage);
                    $('#manufactureImage').attr('src', manufactureImage);
                    $("#productName").val(response?.manufactureOrder?.product?.id);
                    $("#productNameText").text(response?.manufactureOrder?.product?.name_en);
                    $("#manufacturePrice").val(response?.manufactureOrder?.product?.finishing_rate);
                    $("#manufactureQuantity").val(response?.manufactureOrder?.manufacture_quantity);
                    var totalPrice = parseFloat(response?.manufactureOrder?.product?.finishing_rate) *
                        parseFloat(response?.manufactureOrder?.manufacture_quantity);
                    $("#totalPrice").val(totalPrice);
                    $("#message-text").val(response?.manufactureOrder?.message);
                    console.log(totalPrice)

                    console.log(response?.workers)
                    var allOptions = '';
                    for (var i = 0; i < response?.workers?.length; i++) {
                        var singleWorker = response?.workers[i];
                        var options = `<option value="${singleWorker?.user_id}">${singleWorker?.name}</option>`;

                        allOptions += options;
                    }
                    console.log(allOptions)

                    $("#workerAll").html(allOptions)
                    var formAction = "{{ route('manufacture.postManufactureByid', '') }}" + "/" + response
                        ?.manufactureOrder?.id;
                    console.log(formAction)


                    // $("#modalForm").attr()
                    $('#modalForm').attr('action', formAction);

                }
            });
        }


        $('.close').click(function() {
            $("#myModal").modal('hide');
        })
    </script>
@endpush