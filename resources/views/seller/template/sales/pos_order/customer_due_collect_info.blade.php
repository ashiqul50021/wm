@extends('vendor.vendor_master')
@section('vendor')
    <style type="text/css">
        table,
        tbody,
        tfoot,
        thead,
        tr,
        th,
        td {
            border: 1px solid #dee2e6 !important;
        }

        th {
            font-weight: bolder !important;
        }
    </style>

    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Customer Due Collect List</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <!-- card-header end// -->
                    <div class="card-body">
                        <div class="form-group row mb-3">
                        </div>
                        <div class="table-responsive-sm">
                            <table id="example" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>Invoice No.</th>
                                        <th>Date</th>
                                        <th>Customer name</th>
                                        <th>Collected Amount</th>
                                        <th>Remaining Amount</th>
                                        <th class="text-end">Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($dueCollectInfo)
                                        @foreach ($dueCollectInfo as $key => $item)
                                            <tr>
                                                <td>{{ $item->invoice_id ?? 'N/A' }}</td>
                                                <td>{{ $item->created_at->todatestring() ?? 'N/A' }}</td>
                                                <td>{{ $item->customer->name ?? 'N/A' }}</td>
                                                <td>{{ $item->collect_amount ?? 'N/A' }}</td>
                                                <td>{{$item->remaining_amount ?? 'N/A'}}</td>
                                                <td>
                                                   <div>
                                                    <a href="{{route('vendor.pos.dueCollectInfoPrint',$item->id)}}" target="_blank" class="btn btn-primary">Download</a>
                                                    <a href="{{route('vendor.pos.dueCollectInfo.delete',$item->id)}}" class="btn btn-danger">Delete</a>
                                                   </div>
                                                </td>



                                            </tr>
                                        @endforeach
                                    @else
                                        <td>no data found</td>
                                    @endif

                                </tbody>
                            </table>

                        </div>

                        <!-- table-responsive //end -->
                    </div>
                    <!-- card-body end// -->
                </div>
                <!-- card end// -->
            </div>

        </div>
    </section>


@endsection
