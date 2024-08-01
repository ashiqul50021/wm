@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Seller Product Request List <span class="badge rounded-pill alert-success"> {{ count($sellerProduct) }}
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
                                <th scope="col">Regular Price </th>
                                <th scope="col">Wholesale Price </th>
                                <th scope="col">Discount Price </th>
                                <th scope="col">Quantity </th>
                                <th scope="col">Discount </th>
                                <th scope="col">Status</th>
                                <th scope="col">Approved</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sellerProduct as $key => $item)
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

