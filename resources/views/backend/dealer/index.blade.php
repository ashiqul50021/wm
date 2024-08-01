@extends('admin.admin_master')
@section('admin')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Dealer list <span class="badge rounded-pill alert-success"> {{ count($dealers) }} </span></h2>
        <div>
            <a href="{{ route('dealer.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Dealer Create</a>
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
                            <th scope="col">Profile</th>
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
                    @foreach($dealers as $key => $dealer)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td width="15%">
                                <a href="#" class="itemside">
                                    <div class="left">
                                        <img src="{{ asset($dealer->profile_image) }}" class="img-sm img-avatar" alt="Userpic" />
                                    </div>
                                </a>
                            </td>
                            <td> {{ $dealer->user->name ?? ' ' }} </td>
                            <td> {{ $dealer->user->username ?? ' ' }} </td>
                            <td> {{ $dealer->user->email ?? ' ' }} </td>
                            <td> {{ $dealer->user->phone ?? ' ' }} </td>
                            <td>
                                @if($dealer->user->status == 1)
                                    <a @if($dealer->user->is_approved != 0) href="{{ route('dealer.in_active',['id'=>$dealer->user->id]) }}" @endif>
                                        <span class="badge rounded-pill alert-success">Active</span>
                                    </a>
                                @else
                                    <a  href="{{ route('dealer.active',['id'=>$dealer->user->id]) }}" > <span class="badge rounded-pill alert-danger">Disable</span></a>
                                @endif
                            </td>
                            <td>
                                @if($dealer->user->is_approved != 0)
                                    <span class="badge rounded-pill alert-success">Approved</span>
                                @else
                                    <a href="{{ route('admin.dealer.approved',['id'=>$dealer->user->id]) }}">
                                        <span class="badge rounded-pill alert-danger">No Approved</span>
                                    </a>
                                @endif
                            </td>
                        <!-- {{-- <td> {{ $dealer->amount ?? 'NULL' }} </td>
                            <td> {{ $dealer->panding ?? 'NULL' }} </td> --}} -->

                            <td class="text-end">
                                <a class="btn btn-info btn-icon btn-circle font-sm text-white" href="{{ route('dealer.show',$dealer->id) }}">Show info</a>
                                {{--                                <a class="btn {{$dealer->user->is_approved == 0 ? 'btn-success' : 'disabled'}} rounded font-sm" href="{{ route('dealer.edit',$dealer->id) }}">Edit info</a>--}}
                                {{--                                <a class="btn {{$dealer->user->is_approved == 0 ? 'btn-danger' : 'disabled'}} btn-icon btn-circle font-sm" href="{{ route('dealer.delete',$dealer->id) }}" id="delete">Delete</a> --}}
                                <a class="btn btn-success rounded font-sm" href="{{ route('dealer.edit',$dealer->id) }}">Edit info</a>
                                <a class="btn btn-danger btn-icon btn-circle font-sm" href="{{ route('dealer.delete',$dealer->id) }}" id="delete">Delete</a>
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
