@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Worker Request Show</h2>
            <div class="">
                <a href="{{ route('worker.workerRegistration') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Worker Request
                    List</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-10">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset($workerRequest->profile_image ?? '') }}" alt="">
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
                                            <td>{{ $workerRequest->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">User Name</td>
                                            <td>{{ $workerRequest->username ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Phone No.</td>
                                            <td>{{ $workerRequest->phone ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Email</td>
                                            <td>{{ $workerRequest->email ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Manufacture Part</td>
                                            <td>{{ $workerRequest->manufacture_part ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Address</td>
                                            <td>{{ $workerRequest->address ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">NID No.</td>
                                            <td>{{ $workerRequest->nid ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Description</td>
                                            <td>{{ $workerRequest->description ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">NID Photo.</td>
                                            <td><img src="{{ asset($workerRequest->nid_photo ?? '') }}" width="200" height="200" alt=""></td>
                                        </tr>
                                    </tbody>
                                </table>
                               <a href="{{route('worker.workerRegistrationAccept',$workerRequest->id )}}" type="button" class="btn btn-primary">Accept Worker</a>
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

@endpush
