@extends('worker.worker_master')
@section('worker')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">View Payment</h2>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Date</th>
                                <th scope="col">Added To Account</th>
                                <th scope="col">Received</th>
                                <th scope="col">Total Account Balanced</th>


                            </tr>
                        </thead>
                        <tbody>
                            @if ($balances->count() > 0)
                                @foreach ($balances as $key => $item)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td>{{ $item->created_at->format('Y-m-d H:i') ?? '' }}</td>

                                        <td> {{ $item->debit ?? 'NULL' }} </td>
                                        <td> {{ $item->credit ?? '' }} </td>
                                        <td> {{ $item->total ?? '' }} </td>



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
