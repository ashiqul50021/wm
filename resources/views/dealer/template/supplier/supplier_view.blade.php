@extends('dealer.dealer_master')
@section('dealer')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Supplier List <span class="badge rounded-pill alert-success"> {{ count($suppliers) }} </span></h2>
        <div>
            <a href="{{ route('dealer.supplier.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Create Supplier</a>
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
                            <th scope="col">Name</th> 
                            <th scope="col">Phone</th> 
                            <th scope="col">Email</th> 
                            <th scope="col">Address</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $key => $item)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td> {{ $item->name ?? '' }} </td>
                            <td> {{ $item->phone ?? '' }} </td>
                            <td> {{ $item->email ?? '' }} </td>
                            <td> {{ $item->address ?? '' }} </td>
                            <td>
                                @if($item->status == 1)
                                  {{-- <a @if(Auth::guard('admin')->user()->role != '2') href="{{ route('supplier.in_active',['id'=>$item->id]) }}" @endif> --}}
                                  <a>
                                    <span class="badge rounded-pill alert-success">Active</span>
                                  </a>
                                @else
                                  <a> <span class="badge rounded-pill alert-danger">Disable</span></a>
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
