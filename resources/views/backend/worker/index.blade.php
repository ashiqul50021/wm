@extends('admin.admin_master')
@section('admin')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">worker list <span class="badge rounded-pill alert-success"> {{ count($workers) }} </span></h2>
        <div>
            <a href="{{ route('worker.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Worker Create</a>
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
                            <th scope="col">Manufacture Part</th>
                            <th scope="col">Status</th>
                            <!-- <th scope="col">Amount</th> -->
                            <th scope="col">Approved</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workers as $key => $worker)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td width="15%">
                                <a href="#" class="itemside">
                                    <div class="left">
                                        <img src="{{ asset($worker->user->profile_image) }}" class="img-sm img-avatar" alt="Userpic" />
                                    </div>
                                </a>
                            </td>
                            <td> {{ $worker->user->name ?? ' ' }} </td>
                            <td> {{ $worker->user->username ?? ' ' }} </td>
                            <td> {{ $worker->user->email ?? ' ' }} </td>
                            <td> {{ $worker->manufacture_part ?? ' ' }} </td>
                            <td>
                                @if($worker->status == 1)
                                  <a @if($worker->user->is_approved != 0) href="{{ route('worker.in_active',['id'=>$worker->id]) }}" @endif>
                                    <span class="badge rounded-pill alert-success">Active</span>
                                  </a>
                                @else
                                  <a  href="{{ route('worker.active',['id'=>$worker->id]) }}" > <span class="badge rounded-pill alert-danger">Disable</span></a>
                                @endif
                            </td>
                            <td>
                                @if($worker->user->is_approved != 0)
                                    <span class="badge rounded-pill alert-success">Approved</span>
                                @else
                                    <a href="{{ route('admin.worker.approved',['id'=>$worker->user->id]) }}">
                                        <span class="badge rounded-pill alert-danger">No Approved</span>
                                    </a>
                                @endif
                            </td>
                            <!-- {{-- <td> {{ $dealer->amount ?? 'NULL' }} </td>
                            <td> {{ $dealer->panding ?? 'NULL' }} </td> --}} -->

                            <td class="text-end">
                                <a class="btn btn-info btn-icon btn-circle font-sm text-white" href="{{ route('worker.show',$worker->id) }}">Show info</a>
                                <a class="btn btn-md rounded font-sm" href="{{ route('worker.edit',$worker->id) }}">Edit info</a>
                                <a class="btn btn-danger btn-icon btn-circle font-sm" href="{{ route('worker.delete',$worker->id) }}" id="delete">Delete</a>
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
