@extends('dealer.dealer_master')
@section('dealer')

<style type="text/css">
    table, tbody, tfoot, thead, tr, th, td{
        border: 1px solid #dee2e6 !important;
    }
    th{
        font-weight: bolder !important;
    }
</style>

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">All Request List</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <!-- card-header end// -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="example" class="table table-bordered table-striped table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Dealer name</th>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Request Status</th>
                                    <th>Notes</th>
                                    <th class="text-end">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach ($all_requests as $key => $all_request)
                                {{-- @dd($all_requests); --}}
                                <tr>
                                    <td>{{ $key+1}}</td>
                                    <td><b>{{ $all_request->user->name ?? '' }}</b></td>
                                    <td>{{ date('d-m-Y', strtotime($all_request->created_at)) }}</td>
                                    <td>{{ $all_request->total_amount }}</td>
                                    <td>
			                            {{ $all_request->delivery_status }}
                                    </td>
                                    <td>
			                            {{ $all_request->note }}
                                    </td>
                                    <td class="text-end">
			                            <a  class="btn btn-primary btn-icon btn-circle btn-sm btn-xs" href="{{route('dealer.all_request.show',$all_request->id) }}">
			                                <i class="fa-solid fa-eye"></i>
			                            </a>
			                            {{-- <a class="btn btn-primary btn-icon btn-circle btn-sm btn-xs" href="{{ route('invoice.download', $order->id) }}">
			                                <i class="fa-solid fa-download"></i>
			                            </a> --}}
			                            <a href="{{ route('dealer.delete.request',$all_request->id) }}" id="delete" class="btn bg-danger btn-icon btn-circle btn-sm btn-xs" data-href="#" >
			                                <i class="fa-solid fa-trash"></i>
			                            </a>
			                        </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-area mt-25 mb-50">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    {{ $all_requests->links() }}
                                </ul>
                            </nav>
                        </div>
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

@push('footer-script')

@endpush
