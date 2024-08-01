@extends('admin.admin_master')
@section('admin')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Sellers list <span class="badge rounded-pill alert-success"> {{ count($sellers) }} </span></h2>
        <div>
            <a href="{{ route('seller.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Seller Create</a>
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
                            <th scope="col">Shop Profile</th>
                            <th scope="col">Name</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Status</th>
                            <!-- <th scope="col">Amount</th> -->
                            <th scope="col">Approved</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sellers as $key => $seller)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td width="15%">
                                <a href="#" class="itemside">
                                    <div class="left">
                                        <img src="{{ asset($seller->shop_profile) }}" class="img-sm img-avatar" alt="Userpic" />
                                    </div>
                                </a>
                            </td>
                            <td> {{ $seller->shop_name ?? ' ' }} </td>
                            <td> {{ $seller->user->username ?? ' ' }} </td>
                            <td> {{ $seller->user->email ?? ' ' }} </td>
                            <td> {{ $seller->user->phone ?? ' ' }} </td>
                            <td>
                                @if($seller->status == 1)
                                <a href="{{ route('seller.in_active',['id'=>$seller->id]) }}">
                                    <span class="badge rounded-pill alert-success">Active</span>
                                </a>
                                @else
                                    <a href="{{ route('seller.active',['id'=>$seller->id]) }}">
                                        <span class="badge rounded-pill alert-danger">Inactive</span>
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($seller->user && $seller->user->is_approved == 1)
                                <a href="{{ $seller->user ? route('admin.seller.inApproved', ['id' => $seller->user->id]) : '#' }}">
                                <span class="badge rounded-pill alert-success">Approved</span>
                                </a>
                            @else
                            <a href="{{ $seller->user ? route('admin.seller.approved', ['id' => $seller->user->id]) : '#' }}">
                                    <span class="badge rounded-pill alert-danger">Not Approved</span>
                                </a>
                            @endif
                            </td>
                            <!-- {{-- <td> {{ $seller->amount ?? 'NULL' }} </td>
                            <td> {{ $seller->panding ?? 'NULL' }} </td> --}} -->

                            <td class="text-end">
                                {{-- <a href="#" class="btn btn-md rounded font-sm">Detail</a> --}}
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('seller.edit',$seller->id) }}">Edit info</a>
                                        <a class="dropdown-item" href="{{ route('seller.adminChangePassword',$seller->id) }}">Change Password</a>
                                        <a class="dropdown-item text-danger" href="{{ route('seller.delete',$seller->id) }}" id="delete">Delete</a>
                                    </div>
                                </div>
                                <!-- dropdown //end -->
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
