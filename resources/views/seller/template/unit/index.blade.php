@extends('seller.seller_master')
@section('seller')
<section class="content-main">
    <div class="content-header">
        <h3 class="content-title">Unit list <span class="badge rounded-pill alert-success"> {{ count($units) }} </span></h3>
        {{-- <div>
            <a href="{{ route('seller.unit.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Unit Create</a>
        </div> --}}
    </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive-sm">
                <table id="example" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Unit Name</th>
                            <th scope="col">Status</th>
                            {{-- <th scope="col">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $key => $unit)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td> {{ $unit->name ?? '' }} </td>
                            <td>
                                @if($unit->status == 1)
                                  {{-- <a href="{{ route('unit.changeStatus',['id'=>$unit->id]) }}"> --}}
                                  <a>
                                    <span class="badge rounded-pill alert-success"><i class="material-icons md-check"></i></span>
                                  </a>
                                @else
                                  <a> <span class="badge rounded-pill alert-danger"><i class="material-icons md-close"></i></span></a>
                                @endif
                            </td>
                            {{-- <td class="text-end">
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                    @if($unit->seller_id = Auth::guard('seller')->user()->id && $unit->seller_id != NULL)
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('seller.unit.edit', $unit->id) }}">Edit info</a>
                                        <a class="dropdown-item text-danger" href="{{ route('seller.unit.delete',$unit->id) }}" id="delete">Delete</a>
                                    </div>
                                    @endif
                                </div>

                            </td> --}}
                            {{-- @if(Auth::guard('seller')->user()->role = '9')
                            <td class="text-end">
                                @if($unit->created_by = Auth::guard('seller')->user()->id)

                                <a class="btn btn-md rounded font-sm" href="{{ route('seller.unit.edit',$unit->id) }}">Edit</a>
                                <a class="btn btn-md rounded font-sm bg-danger" href="{{ route('seller.unit.delete',$unit->id) }}" id="delete">Delete</a>
                                @endif
                            </td>
                            @endif --}}
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
