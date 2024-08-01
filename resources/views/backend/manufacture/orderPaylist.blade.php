@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Order Payment List <span class="badge rounded-pill alert-success">
                    @if (!empty($payments))
                        {{ count($payments) }}
                    @endif
                </span></h2>
            <div>
                <a href="{{ route('manufacture.orderPayment') }}" class="btn btn-primary"><i
                        class="material-icons md-plus"></i>Create Payment
                    Product</a>
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
                                <th scope="col">Payment Date.</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Worker Name</th>
                                <!--<th scope="col">Product Price </th>-->
                                <th scope="col">Quantity</th>
                                <th scope="col">Manufacture Part</th>
                                <th scope="col">Manufacture Price</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Paid Amount</th>
                                <th scope="col">Due Amount</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($payments->count() > 0)
                                @foreach ($payments as $key => $item)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                        <td> {{ $item->manufacture->product->name_en ?? 'NULL' }} </td>
                                        <td> {{ $item->manufacture->user->name ?? 'NULL' }} </td>
                                        <td> {{ $item->manufacture->manufacture_quantity ?? 'NULL' }} </td>
                                        <td> {{ $item->manufacture->manufacture_part ?? 'NULL' }} </td>
                                        <td> {{ $item->manufacture->manufacture_price ?? 'NULL' }} </td>
                                        <td> {{ $item->total_price }} </td>
                                        <td> {{ $item->pay_amount }} </td>
                                        <td> {{ $item->due_amount }} </td>
                                        <td>
                                            @if ($item->due_amount == 0)

                                                    <p class="badge rounded-pill alert-success">Paid</p>

                                            @else
                                                 <p
                                                        class="badge rounded-pill alert-danger">Partial Paid</p>
                                            @endif
                                        </td>

                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" data-bs-toggle="dropdown"
                                                    class="btn btn-light rounded btn-sm font-sm"> <i
                                                        class="material-icons md-more_horiz"></i> </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('manufacture.paymentedit', $item->id) }}">Edit
                                                        info</a>
                                                    @if (Auth::guard('admin')->user()->role == '2')
                                                        <a class="dropdown-item text-danger"
                                                            href="{{ route('manufacture.orderDelete', $item->id) }}"
                                                            id="delete">Delete</a>
                                                    @else
                                                        @if (Auth::guard('admin')->user()->role == '1' ||
                                                                in_array('4', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                                                            <a class="dropdown-item text-danger"
                                                                href="{{ route('manufacture.orderDelete', $item->id) }}"
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
