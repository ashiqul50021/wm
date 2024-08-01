@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Customer Due List <span class="badge rounded-pill alert-success">
                    {{ count($customerDue) }} </span></h2>
            <div>
                {{-- <a href="{{ route('') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Add Product</a> --}}
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
                                <th scope="col">Customer Name</th>
                                <th scope="col">Total Due</th>

                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customerDue as $key => $item)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $item->customer->name ?? 'NULL' }} </td>
                                    <td width="15%">
                                        {{ $item->total_due ?? 'NULL' }}
                                    </td>
                                    <td >
                                        <div class="float-end">
                                            <a href="{{route('pos.dueCollect',$item->id)}}" class="btn btn-secondary">Collect Payment</a>
                                        </div>

                                    </td>


                                    {{--
                            <td class="text-end">
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('product.edit',$item->id) }}">Edit info</a>
                                        <a class="dropdown-item" href="{{ route('product.duplicate',$item->id) }}">Duplicate</a>
                                        <!-- <a class="dropdown-item" href="">View Details</a> -->
                                        @if (Auth::guard('admin')->user()->role == '2')
                                            <a class="dropdown-item text-danger" href="{{ route('product.delete',$item->id) }}" id="delete">Delete</a>
                                        @else
                                            @if (Auth::guard('admin')->user()->role == '1' || in_array('4', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                                                <a class="dropdown-item text-danger" href="{{ route('product.delete',$item->id) }}" id="delete">Delete</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <!-- dropdown //end -->
                            </td> --}}
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
