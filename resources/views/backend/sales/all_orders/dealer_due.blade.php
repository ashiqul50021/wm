@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Dealer Due Order list <span class="badge rounded-pill alert-success">
                    {{ count($dueOrder) }} </span></h2>
                    <div>
                        <a href="{{route('admin.dealer.dealerReorder')}}" type="button" class="btn btn-primary">Dealer Reorder</a>
                    </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Dealer</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Body Price</th>
                                <th scope="col">Finishing Price</th>
                                <th scope="col">Unit Price</th>

                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dueOrder as $key => $order)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $order->user->name ?? ' ' }} </td>
                                    <td width="15%">
                                        <a href="#" class="itemside">
                                            <div class="left">
                                                <img src="{{ asset($order->product->product_thumbnail ?? '') }}" class=""
                                                    height="150" width="150" alt="Userpic" />
                                            </div>
                                        </a>
                                    </td>
                                    <td>{{ $order->product->name_en ?? '-' }}</td>
                                    <td> {{ $order->qty ?? ' ' }} </td>
                                    <td> {{ $order->product->body_rate ?? ' ' }} </td>
                                    <td> {{ $order->product->finishing_rate ?? ' ' }} </td>

                                    <td>{{ $order->unit_price ?? '' }}</td>

                                    <td class="text-end">
                                        <a class="btn btn-info btn-icon btn-circle font-sm text-white"
                                            href="{{ route('admin.dealer.order.dueManufacture', $order->id) }}">Assign
                                            Worker</a>
                                        <a class="btn btn-danger btn-icon btn-circle font-sm"
                                            href="{{ route('admin.dealer.order.dueDelete', $order->id) }}"
                                            id="delete">Delete</a>
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
