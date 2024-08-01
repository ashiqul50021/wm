@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Worker Show</h2>
            <div class="">
                <a href="{{ route('worker.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Worker
                    List</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-10">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset($worker->user->profile_image) }}" alt="">
                            </div>
                            <div class="col-md-8">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Info</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold">Name</td>
                                            <td>{{ $worker->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">User Name</td>
                                            <td>{{ $worker->user->username }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Phone No.</td>
                                            <td>{{ $worker->user->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Email</td>
                                            <td>{{ $worker->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Address</td>
                                            <td>{{ $worker->user->address }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">NID No.</td>
                                            <td>{{ $worker->nid }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Description</td>
                                            <td>{{ $worker->description }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <h3>Order info</h3>
                           <div class="row">
                            <div class="col-md-4 col-xl-3">
                                <div class="card bg-c-blue order-card"  style="background-color: #55A4FF;">
                                    <div class="card-block" >
                                        <h6 class="m-b-20" style="color:white">Orders Complete</h6>

                                        <h2 class="text-right" style="color:white"><i class="fa fa-cart-plus f-left"></i><span>{{$workerOrder->count()}}</span></h2>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="card bg-c-blue order-card"  style="background-color: #45DCBE;">
                                    <div class="card-block" >
                                        <h6 class="m-b-20" style="color:white">Orders Pending</h6>

                                        <h2 class="text-right" style="color:white"><i class="fa fa-cart-plus f-left"></i><span>{{$workerOrderPending->count()}}</span></h2>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="card bg-c-blue order-card"  style="background-color: #FFC167;">
                                    <div class="card-block" >
                                        <h6 class="m-b-20" style="color:white">Total Amount</h6>

                                        <h2 class="text-right" style="color:white"><i class="fa fa-cart-plus f-left"></i><span>{{$workerOrderPending->count()}}</span></h2>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="card bg-c-blue order-card"  style="background-color: #FF6E86;">
                                    <div class="card-block" >
                                        <h6 class="m-b-20" style="color:white">Total Paid</h6>

                                        <h2 class="text-right" style="color:white"><i class="fa fa-cart-plus f-left"></i><span>{{$workerOrderPending->count()}}</span></h2>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="card bg-c-blue order-card"  style="background-color: #3BB77E;">
                                    <div class="card-block" >
                                        <h6 class="m-b-20" style="color:white">Total Due</h6>

                                        <h2 class="text-right" style="color:white"><i class="fa fa-cart-plus f-left"></i><span>{{$workerOrderPending->count()}}</span></h2>

                                    </div>
                                </div>
                            </div>
                           </div>
                        </div>
                    </div>
                    <!-- card body .// -->
                </div>
                <!-- card .// -->
            </div>
        </div>
    </section>
@endsection

@push('footer-script')
    <!-- Shop Cover Photo Show -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image2').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage2').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <!-- Nid Card Show -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image3').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage3').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <!-- Trade license Show -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image4').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage4').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endpush
