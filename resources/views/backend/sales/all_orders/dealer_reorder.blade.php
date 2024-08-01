@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Dealer list <span class="badge rounded-pill alert-success">
                    {{ count($dealers) }} </span></h2>

        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Dealer</th>
                                <th scope="col">Total Product</th>
                                <th scope="col" class="">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dealers as $key => $dealer)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $dealer->name ?? ' ' }} </td>
                                    <td> {{ $dealer->dealerDue->count() ?? ' ' }} </td>

                                    <td>
                                        <a href="{{route('admin.dealer.dealerReorderDetails',$dealer->id)}}" class="btn btn-primary">details</a>
                                        <a href="" class="btn btn-danger">delete</a>
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
