@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Product List <span class="badge rounded-pill alert-success"> {{ count($products) }}
                </span></h2>
            <div>
                <a href="{{ route('product.add') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Add
                    Product</a>
            </div>
        </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Name (English)</th>
                                <th scope="col">Name (Bangla)</th>
                                {{-- <th scope="col">Category</th> --}}
                                <th scope="col">Model </th>
                                <th scope="col">Regular Price </th>
                                <th scope="col">Wholesale Price </th>
                                <th scope="col">Discount Price </th>
                                <th scope="col">Quantity </th>
                                <th scope="col">Discount </th>
                                <th scope="col">Featured</th>
                                <th scope="col">Status</th>
                                <th scope="col">Approved</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $item)
                            {{-- @dd($item); --}}
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td width="10%">
                                        <a href="#" class="itemside">
                                            <div class="left">
                                                @if ($item->product_thumbnail)
                                                    <img src="{{ asset($item->product_thumbnail) }}" class="img-sm"
                                                        alt="Userpic" style="width: 80px; height: 70px;">
                                                @else
                                                    <img class="img-lg mb-3" src="{{ asset('upload/no_image.jpg') }}"
                                                        alt="Userpic" style="width: 80px; height: 70px;" />
                                                @endif
                                            </div>
                                        </a>
                                    </td>
                                    <td> {{ $item->name_en ?? 'NULL' }} </td>
                                    <td> {{ $item->name_bn ?? 'NULL' }} </td>
                                    {{-- <td> {{ $item->category->name_en }} </td> --}}
                                    <td>{{ $item->model_number ?? '-' }}</td>
                                    <td> {{ $item->regular_price ?? 'NULL' }} </td>
                                    <td>{{ $item->wholesell_price ?? 'NULL' }}</td>

                                    @php
                                        $discount = ($item->regular_price * $item->discount_price) / 100;
                                        $amount = $item->regular_price - $discount;
                                    @endphp
                                     <td> {{ $amount ?? 'No Discount'}} </td>
                                     <td id="stock_qty_{{ $item->id }}">
                                        {{ $item->stock_qty ?? 'NULL' }}
                                    </td>
                                    <td>
                                        @if ($item->discount_price > 0)
                                            @if ($item->discount_type == 1)
                                                <span class="badge rounded-pill alert-info">৳{{ $item->discount_price }}
                                                    off</span>
                                            @elseif($item->discount_type == 2)
                                                <span class="badge rounded-pill alert-success">{{ $item->discount_price }}%
                                                    off</span>
                                            @endif
                                        @else
                                            <span class="badge rounded-pill alert-danger">No Discount</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->is_featured == 1)
                                            <a href="{{ route('product.featured', ['id' => $item->id]) }}">
                                                <span class="badge rounded-pill alert-success"><i
                                                        class="material-icons md-check"></i></span>
                                            </a>
                                        @else
                                            <a href="{{ route('product.featured', ['id' => $item->id]) }}"> <span
                                                    class="badge rounded-pill alert-danger"><i
                                                        class="material-icons md-close"></i></span></a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 1)
                                            <a href="{{ route('product.in_active', ['id' => $item->id]) }}">
                                                <span class="badge rounded-pill alert-success">Active</span>
                                            </a>
                                        @else
                                            <a href="{{ route('product.active', ['id' => $item->id]) }}"> <span
                                                    class="badge rounded-pill alert-danger">Disable</span></a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->approved != 0)
                                            <span class="badge rounded-pill alert-success">Approved</span>
                                        @else
                                            <a href="{{ route('product.approved', ['id' => $item->id]) }}">
                                                <span class="badge rounded-pill alert-danger">No Approved</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-light rounded btn-sm font-sm"> <i
                                                    class="material-icons md-more_horiz"></i> </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('product.edit', $item->id) }}" target="_blank">Edit Info</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#updateQuantityModal"
                                                    data-product-id="{{ $item->id }}">Update Quantity</a>
                                                    {{-- update quantity information --}}
                                                    <a class="dropdown-item" href="{{ route('product.quantity.info', $item->id) }}" target="_blank">Quantity Update Info</a>
                                                <a class="dropdown-item" target="_blank"
                                                    href="{{ route('product.duplicate', $item->id) }}">Duplicate</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('product.barcodeGenarate', $item->id) }}">Barcode
                                                    Generate</a>
                                                <!-- <a class="dropdown-item" href="">View Details</a> -->
                                                @if (Auth::guard('admin')->user()->role == '2')
                                                    <a class="dropdown-item text-danger"
                                                        href="{{ route('product.delete', $item->id) }}"
                                                        id="delete">Delete</a>
                                                @else
                                                    @if (Auth::guard('admin')->user()->role == '1' ||
                                                            in_array('4', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                                                        <a class="dropdown-item text-danger"
                                                            href="{{ route('product.delete', $item->id) }}"
                                                            id="delete">Delete</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <!-- dropdown //end -->
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


        <!-- Update Quantity Modal -->
        <div class="modal fade" id="updateQuantityModal" tabindex="-1" aria-labelledby="updateQuantityModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateQuantityModalLabel">Update Quantity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateQuantityForm">
                            @csrf
                            <label for="quantity">New Quantity:</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="0"
                                required>
                            <input type="hidden" name="product_id" id="product_id">
                            <button type="submit" class="btn btn-primary mt-3">Update Quantity</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Modal Section  --}}
    </section>
@endsection

@push('footer-script')
    {{-- <script>
        $(document).ready(function() {
            var originalQuantity;

            $('#updateQuantityModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var productId = button.data('product-id');
                originalQuantity = parseInt($('#stock_qty_' + productId).text(), 10);
                $('#quantity').val(0);
                $('#product_id').val(productId);
            });

            $('#updateQuantityForm').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                var enteredQuantity = parseInt($('#quantity').val(), 10);
                var updatedQuantity = originalQuantity + enteredQuantity;

                $.ajax({
                    type: 'POST',
                    url: '{{ route('update.quantity', ['id' => ':id']) }}'.replace(':id', $('#product_id').val()),
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#stock_qty_' + $('#product_id').val()).text(updatedQuantity);
                            $('#updateQuantityModal').modal('hide');
                            toastr.success('Stock Quantity Updated Successfully');
                        } else {
                            toastr.error(response.message);
                            $('#quantity').val(0);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            var originalQuantity;

            $('#updateQuantityModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var productId = button.data('product-id');
                originalQuantity = parseInt($('#stock_qty_' + productId).text(), 10);
                $('#quantity').val(0);
                $('#product_id').val(productId);
            });

            $('#updateQuantityForm').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                var enteredQuantity = parseInt($('#quantity').val(), 10);
                var updatedQuantity = originalQuantity + enteredQuantity;

                $.ajax({
                    type: 'POST',
                    url: '{{ route('update.quantity', ['id' => ':id']) }}'.replace(':id', $('#product_id').val()),
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#stock_qty_' + $('#product_id').val()).text(updatedQuantity);
                            $('#updateQuantityModal').modal('hide');
                            toastr.success('Stock Quantity Updated Successfully');
                        } else {
                            toastr.error(response.message);
                            $('#quantity').val(0);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>


@endpush
