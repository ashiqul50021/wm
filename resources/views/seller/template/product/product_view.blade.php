@extends('seller.seller_master')
@section('seller')
    @php
        use App\Models\Seller;
        // use App\Models\VendorRole;
        $user = Auth::guard('seller')->user();
        // $vendorId = Auth::guard('vendor')->user()->vendor_id;
        // $vendorRole = VendorRole::where('vendor_id', $vendorId)->first();
    @endphp

    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Product List <span class="badge rounded-pill alert-success"> {{ count($products) }}
                </span></h2>
            <div>
                @if ($user->role == '9')
                    <a href="{{ route('seller.product.add') }}" class="btn btn-primary"><i
                            class="material-icons md-plus"></i>Add
                        Product</a>
                @endif

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
                                <th scope="col">Category</th>
                                <th scope="col">Product Price </th>
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
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td width="15%">
                                        <a href="#" class="itemside">
                                            <div class="left">
                                                <img src="{{ asset($item->product_thumbnail) }}" class="img-sm"
                                                    alt="Userpic" style="width: 80px; height: 70px;">
                                            </div>
                                        </a>
                                    </td>
                                    <td> {{ $item->name_en ?? 'NULL' }} </td>
                                    <td> {{ $item->name_bn ?? 'NULL' }} </td>
                                    <td> {{ $item->category->name_en ?? '' }} </td>
                                    <td> {{ $item->regular_price ?? 'NULL' }} </td>
                                    <td>

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
                                            <a href="{{ route('seller.product.featured', ['id' => $item->id]) }}">
                                                <span class="badge rounded-pill alert-success"><i
                                                        class="material-icons md-check"></i></span>
                                            </a>
                                        @else
                                            <a href="{{ route('seller.product.featured', ['id' => $item->id]) }}"> <span
                                                    class="badge rounded-pill alert-danger"><i
                                                        class="material-icons md-close"></i></span></a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 1)
                                            <a href="{{ route('seller.product.in_active', ['id' => $item->id]) }}">
                                                <span class="badge rounded-pill alert-success">Active</span>
                                            </a>
                                        @else
                                            <a href="{{ route('seller.product.active', ['id' => $item->id]) }}"> <span
                                                    class="badge rounded-pill alert-danger">Disable</span></a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->approved != 0)
                                            <span class="badge rounded-pill alert-success">Approved</span>
                                        @else
                                            <span class="badge rounded-pill alert-danger">Not Approved</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-light rounded btn-sm font-sm"> <i
                                                    class="material-icons md-more_horiz"></i> </a>
                                            @if ($item->seller_id == Auth::guard('seller')->user()->id && $item->seller_id != null)
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('seller.product.edit', $item->id) }}">Edit info</a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('seller.product.duplicate', $item->id) }}">Duplicate
                                                        Product</a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('seller.product.barcodeGenarate', $item->id) }}">Barcode
                                                        Generate</a>
                                                    <!-- <a class="dropdown-item" href="">View Details</a> -->
                                                    <a class="dropdown-item text-danger"
                                                        href="{{ route('seller.product.delete', $item->id) }}"
                                                        id="delete">Delete</a>
                                                </div>
                                            @endif
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
    </section>
@endsection
