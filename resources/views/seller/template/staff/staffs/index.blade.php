@extends('vendor.vendor_master')
@section('vendor')
    <section class="content-main">
        <div class="content-header">
            <h3 class="content-title">Staff list <span class="badge rounded-pill alert-success"> {{ count($staffs) ?? 0 }}
                </span></h3>
            <div>
                <a href="{{ route('vendor.staff.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Add
                    New Staff</a>
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
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Role</th>

                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($staffs)
                                @foreach ($staffs as $key => $staff)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td> {{ $staff->user->name ?? 'NULL' }} </td>
                                        <td> {{ $staff->user->email ?? 'NULL' }} </td>
                                        <td> {{ $staff->user->phone ?? 'NULL' }} </td>
                                        <td> {{ $staff->vendorrole->name ?? 'NULL' }} </td>

                                        <td>
                                            <a class="btn btn-primary btn-icon btn-circle btn-sm btn-xs"
                                                href="{{ route('vendor.staff.edit', $staff->id) }}">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            <a href="{{ route('vendor.staff.destroy', $staff->id) }}" id="delete"
                                                class="btn btn-primary btn-icon btn-circle btn-sm btn-xs" data-href="#">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <p>No data found!</p>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- table-responsive //end -->
            </div>
            <!-- card-body end// -->
        </div>
    </section>
@endsection
