@extends('admin.admin_master')
@section('admin')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Out Customer List <span class="badge rounded-pill alert-success"> {{ count($customers) }} </span></h2>
        {{-- <div>
            <a href="#" class="btn btn-primary"><i class="material-icons md-plus"></i> Create Customer</a>
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
                            <th scope="col">Profile</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $key => $customer)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td> <img src="{{asset($customer->profile_image ?? '')}}" style="height: 100px; width:100px;border-radius: 50px" alt="profile Image"> </td>
                            <td> {{ $customer->name ?? 'No Name' }} </td>
                            <td> {{ $customer->phone ?? 'No Phone Number' }} </td>
                            <td> {{ $customer->email ?? 'No Email' }} </td>
                            <td> {{ $customer->address ?? 'No Address' }} </td>
                            <td class="text-end">
                                <a href="{{route('customer.show',$customer->id)}}" class="btn btn-md rounded font-sm">Detail</a>
                                <a href="{{route('customer.edit',$customer->id)}}" class="btn btn-md rounded font-sm">Edit</a>
                                <a href="{{route('customer.delete',$customer->id)}}" class="btn btn-danger rounded font-sm">Delete</a>
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
