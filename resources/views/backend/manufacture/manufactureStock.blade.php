@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Manufacture Product Stock List <span class="badge rounded-pill alert-success">
                    @if (!empty($manufactureStocks))
                        {{ count($manufactureStocks) }}
                    @endif
                </span></h2>
            {{-- <div>
                <a href="{{ route('manufacture.orderPayment') }}" class="btn btn-primary"><i
                        class="material-icons md-plus"></i>Create Payment
                    Product</a>
            </div> --}}
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
                                <th scope="col">Product Name</th>
                                <th scope="col">Body Part Quantity</th>
                                <th scope="col">Finishing Part Quantity</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($manufactureStocks->count() > 0)
                                @foreach ($manufactureStocks as $key => $item)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td width="15%">
                                            <a href="#" class="itemside">
                                                <div class="left">
                                                    @if ($item->product->product_thumbnail ?? '')
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
                                        <td width="15%">

                                                <div class="left">
                                                    @if ($item->product->menu_facture_image ?? '')
                                                        <img src="{{ asset($item->product->menu_facture_image) }}"
                                                            class="img-sm" alt="Userpic"
                                                            style="width: 80px; height: 70px;">
                                                    @else
                                                        <img class="img-lg mb-3" src="{{ asset('upload/no_image.jpg') }}"
                                                            alt="Userpic" style="width: 80px; height: 70px;" />
                                                    @endif
                                                </div>

                                        </td>
                                        <td>{{ $item->product->name_en ?? '-' }}</td>

                                        <td> {{ $item->body_part_stock ?? '0' }} </td>
                                        <td> {{ $item->finishing_part_stock ?? '0' }} </td>



                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" data-bs-toggle="dropdown"
                                                    class="btn btn-light rounded btn-sm font-sm"> <i
                                                        class="material-icons md-more_horiz"></i> </a>
                                                <div class="dropdown-menu">

                                                    @if (Auth::guard('admin')->user()->role == '2')
                                                        <a class="dropdown-item text-danger"
                                                            href="{{ route('manufacture.ManufactureStockDelete', $item->id) }}"
                                                            id="delete">Delete</a>
                                                    @else
                                                        @if (Auth::guard('admin')->user()->role == '1' ||
                                                                in_array('4', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                                                            <a class="dropdown-item text-danger"
                                                                href="{{ route('manufacture.ManufactureStockDelete', $item->id) }}"
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
@endsection
