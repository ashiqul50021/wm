@extends('worker.worker_master')
@section('worker')
@php
    $manufacturePriceSum = 0;
    $totalPriceSum = 0;
    $totalQuantitySum = 0;
@endphp
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Pending Orders</h2>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('worker.pendingDateWiseSearch') }}" method="get" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <label for="start_date">Start Date:</label>
                        <input type="date" name="start_date" id="start_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date">End Date:</label>
                        <input type="date" name="end_date" id="end_date" class="form-control">
                    </div>
                    <div class="col-md-2 mt-4">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive-sm">
                <table id="example" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Manufacture Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Worker Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Manufacture Part</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Status</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Order update Date</th>

                        </tr>
                    </thead>
                    {{-- <tbody>
                        @if ($orders->count() > 0)
                        @foreach ($orders as $key => $item)
                        <tr>
                            <td> {{ $key + 1 }} </td>
                            <td width="15%">
                                <a target="_blank" href="{{route('worker.worker.printOrder',$item->id)}}" class="itemside">
                                    <div class="left">
                                        @if ($item->product->menu_facture_image)
                                            <img src="{{ asset($item->product->menu_facture_image) }}" class="img-sm"
                                                alt="Userpic" style="width: 80px; height: 70px;">
                                        @else
                                            <img class="img-lg mb-3" src="{{ asset('upload/no_image.jpg') }}"
                                                alt="Userpic" style="width: 80px; height: 70px;" />
                                        @endif
                                    </div>
                                </a>
                            </td>
                            <td> {{ $item->product->name_en ?? 'NULL' }} </td>

                            <td> {{ $item->manufacture_quantity ?? 'NULL' }} </td>
                            <td> {{ $item->manufacture_part }} </td>
                            <td>
                                {{ $item->created_at->format('M j, Y h:i A') }}
                            </td>
                            <td>
                                {{ $item->updated_at->format('M j, Y h:i A') }}
                            </td>
                            <td>
                                @if ($item->is_complete == 1)
                                <p><span class="badge rounded-pill alert-success">Completed</span></p>

                                @else
                                  <p> <span class="badge rounded-pill alert-danger">pending</span></p>
                                @endif
                            </td>

                        </tr>
                       @endforeach
                        @else
                        <p class="text-center">no data found</p>
                        @endif

                    </tbody> --}}

                    <tbody>
                        @if ($pendingOrders->count() > 0)
                            @foreach ($pendingOrders as $key => $item)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $item->customer_name ?? 'NULL' }} </td>
                                    <td width="10%">
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
                                    <td width="10%">
                                        <a href="{{ route('worker.manufacture.printOrder', $item->id) }}" target="_blank" class="itemside">
                                            <div class="left">
                                                @if ($item->product->menu_facture_image?? '')
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
                                    <td> {{ $item->manufacture_part ?? '-' }} </td>
                                    <td width="10%"> {{ $item->total_price ?? '' }} </td>
                                    <td>
                                        @if ($item->is_complete == 1)
                                        <span class="badge rounded-pill alert-success">Completed</span>
                                        @else
                                        <span class="badge rounded-pill alert-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->created_at->format('M j, Y h:i A') }}
                                    </td>
                                    <td>
                                        {{ $item->updated_at->format('M j, Y h:i A') }}
                                    </td>

                                </tr>
                                @php

                                $totalPriceSum += $item->total_price ?? 0;
                                $totalQuantitySum += $item->manufacture_quantity ?? 0;
                                @endphp

                            @endforeach


                        @else
                            <p class="text-center">no data found</p>
                        @endif

                    </tbody>
                    <tr class="text-bold">
                        <td colspan="5"></td>
                        <td style="font-weight: 900;">Total Quantity: {{ $totalQuantitySum }}</td>
                        <td></td>
                        <td style="font-weight: 900;">Total Price: {{ $totalPriceSum }}</td>
                        <td colspan="5"></td>
                    </tr>
                </table>
            </div>
            <!-- table-responsive //end -->
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
</section>
@endsection
