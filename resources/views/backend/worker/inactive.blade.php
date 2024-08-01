@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Worker Balance List</h2>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Worker Name</th>
                                <th scope="col">Total Balance</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>



                            </tr>
                        </thead>
                        <tbody>
                            @if ($workerBalances->count() > 0)
                                @foreach ($workerBalances as $key => $item)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td> {{ $item->user->name ?? 'NULL' }} </td>

                                        <td> {{ $item->total_balance ?? 'NULL' }} </td>

                                        <td> {{ $item->status == 0 ? 'Inactive':'Active' }} </td>
                                        <td>
                                            <a href="{{route('worker.change.status', $item->id)}}" class="btn {{$item->status == 1? 'btn-success' : 'btn-danger'}}">{{$item->status== 1 ? 'Active' : 'Inactive'}}</a>

                                    </tr>
                                @endforeach
                            @else
                                <p class="text-center">no data found</p>
                            @endif

                        </tbody>
                    </table>
                </div>
                <!-- table-responsive //end -->
            </div>
            <!-- card-body end// -->
        </div>
        <!-- card end// -->
    </section>
@endsection
