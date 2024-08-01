@extends('seller.seller_master')
@section('seller')
    @php
        use App\Models\Seller;
        use App\Models\VendorRole;
        $user = Auth::guard('seller')->user();
        // $vendorId = Auth::guard('vendor')->user()->vendor_id;
        // $vendorRole = VendorRole::where('vendor_id', $vendorId)->first();

    @endphp
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Supplier List <span class="badge rounded-pill alert-success"> {{ count($suppliers) }}
                </span></h2>
            {{-- <div>
                @if ($user->role == '9')
                    <a href="{{ route('seller.supplier.create') }}" class="btn btn-primary"><i
                            class="material-icons md-plus"></i>
                        Create Supplier</a>
                @endif
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
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Address</th>
                                <th scope="col">Status</th>
                                {{-- <th scope="col">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $key => $item)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $item->name ?? '' }} </td>
                                    <td> {{ $item->phone ?? '' }} </td>
                                    <td> {{ $item->email ?? '' }} </td>
                                    <td> {{ $item->address ?? '' }} </td>
                                    <td>
                                        @if ($item->status == 1)
                                            {{-- <a @if (Auth::guard('admin')->user()->role != '2') href="{{ route('supplier.in_active',['id'=>$item->id]) }}" @endif> --}}
                                            <a>
                                                <span class="badge rounded-pill alert-success">Active</span>
                                            </a>
                                        @else
                                            <a> <span class="badge rounded-pill alert-danger">Disable</span></a>
                                        @endif
                                    </td>

                                    {{-- <td>
                                        @if($item->seller_id == Auth::guard('seller')->user()->id && $item->seller_id != NULL)
                                            <a class="btn btn-warning" type="button"
                                                href="{{ route('seller.supplier.edit', $item->id) }}">Edit</a>

                                            <a class="btn btn-danger" type="button"
                                                href="{{ route('seller.supplier.destroy', $item->id) }}">Delete</a>
                                        @endif
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
