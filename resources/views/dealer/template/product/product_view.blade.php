@extends('dealer.dealer_master')
@section('dealer')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Product List <span class="badge rounded-pill alert-success"> {{ count($products) }} </span></h2>
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
                            <th scope="col">Wholesell Price</th>
							<th scope="col">Minimum Quantity</th>
							<th scope="col">Regular Price </th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($products as $key => $item)
                        {{-- @dd($item); --}}
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td width="15%">
                                <a href="#" class="itemside">
                                    <div class="left">
                                        <img src="{{ asset($item->product_thumbnail) }}" class="img-sm" alt="Userpic" style="width: 80px; height: 70px;">
                                    </div>
                                </a>
                            </td>
                            <td> {{ $item->name_en ?? '' }} </td>
                            <td> {{ $item->name_bn ?? '' }} </td>
                            <td> {{ $item->category->name_en ?? '' }} </td>
                            <td> {{ $item->wholesell_price ?? '' }} </td>
                            <td>
                              {{$item->wholesell_minimum_qty ?? ''}}
                            </td>
                            <td>
                                {{ $item->regular_price ?? '' }}
                            </td>
                            {{-- @if($item->$childCategory ?? '') --}}
                            <td class="text-end">
                                <a  class="btn btn-primary btn-icon btn-circle btn-sm btn-xs" href="{{route('dealer.product.show',$item->id) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                            {{-- @endif --}}



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
