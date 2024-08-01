@extends('admin.admin_master')
@section('admin')
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
                <h2 class="content-title card-title">Pos Order List</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <!-- card-header end// -->
                    <div class="card-body">
                        <form class="" action="{{ route('searchByPosReport') }}" method="GET">
                            <div class="form-group row mb-3">
                                <div class="col-md-2">
                                    <label class="col-form-label"><span>All Pos Orders :</span></label>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <div class="custom_select">
                                        <select
                                            class=" select-active select-nice form-select d-inline-block mb-lg-0 mr-5 mw-200"
                                            name="vendor_id" id="vendor_id">
                                            <option value="" selected="">Vendor</option>
                                            <option value="0">AA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2">
                                    {{-- <div class="custom_select">
                                        <select
                                            class="form-select d-inline-block select-active select-nice mb-lg-0 mr-5 mw-200"
                                            name="delivery_status" id="delivery_status">
                                            <option value="" selected="">Delivery Status</option>
                                            <option value="pending" @if ($delivery_status == 'pending') selected @endif>
                                                Pending</option>
                                            <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>
                                                Confirmed</option>
                                            <option value="shipped" @if ($delivery_status == 'shipped') selected @endif>
                                                Shipped</option>
                                            <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>
                                                Picked Up</option>
                                            <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>On
                                                The Way</option>
                                            <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>
                                                Delivered</option>
                                            <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>
                                                Cancel</option>
                                        </select>
                                    </div> --}}
                                </div>
                                <div class="col-md-2 mt-2">
                                    {{-- <div class="custom_select">
                                        <select
                                            class=" select-active select-nice form-select d-inline-block mb-lg-0 mr-5 mw-200"
                                            name="payment_status" id="payment_status">
                                            <option value="" selected="">Payment Status</option>
                                            <option value="0" @if ($payment_status == '0') selected @endif>Unpaid
                                            </option>
                                            <option value="1" @if ($payment_status == '1') selected @endif>Paid
                                            </option>
                                        </select>
                                    </div> --}}
                                </div>
                                <div class="col-md-2 mt-2">
                                    <div class="custom_select">
                                        <input type="text" id="reportrange" class="form-control" name="date"
                                            placeholder="Filter by date" data-format="DD-MM-Y" value="Filter by date"
                                            data-separator=" - " autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <button class="btn btn-primary" type="submit">Filter</button>
                                </div>
                            </div>
                            <div class="table-responsive-sm">
                                <table id='example' class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Invoice No.</th>
                                            <!-- <th>Num. Of Products</th> -->
                                            <th>Customer name</th>
                                            <th>Price</th>
                                            <th>Overall Discount</th>
                                            <th>After Discount</th>
                                            <th>Paid Amount</th>
                                            <th>Due Amount</th>
                                            <th>Payment Status</th>
                                            <th>Sale By</th>
                                            <th class="text-end">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($posOrder)
                                            @foreach ($posOrder as $key => $order)
                                            {{-- @dd($order); --}}
                                                <tr>
                                                    <td>{{ $order->invoice_no }}</td>
                                                    <td><b>
                                                            @if ($order->user->role == 4 )
                                                            {{-- @if ($order->user && ($order->user->role == null || $order->user->role == 4)) --}}
                                                                Walk-in Customer
                                                            @else
                                                                {{ $order->user->name ?? 'Walk-in Customer' }}
                                                            @endif
                                                        </b></td>

                                                    <td>

                                                        {{ $order->subtotal ?? 0 }}
                                                    </td>
                                                    <td>

                                                        {{ $order->overall_discount ?? 0 }}
                                                    </td>
                                                    <td>

                                                        {{ $order->total ?? 0 }}
                                                    </td>

                                                    <td>

                                                        {{ $order->paid ?? 0 }}
                                                    </td>
                                                    <td>

                                                        {{ $order->due ?? 0 }}
                                                    </td>

                                                    <td>
                                                        @if ($order->due == 0)
                                                            <span class="badge rounded-pill alert-success">Paid</span>
                                                        @elseif($order->due > 0 || $order->due < $order->total)
                                                            <span class="badge rounded-pill alert-warning">partial
                                                                paid</span>
                                                        @else
                                                            <span class="badge rounded-pill alert-danger">Un-Paid</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $order->saleby->name ?? 'N/A' }}</td>
                                                    <td class="text-end">
                                                        <a class="btn btn-primary btn-icon btn-circle btn-sm btn-xs"
                                                            href="{{ route('pos.orderShow', $order->id) }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a class="btn btn-primary btn-icon btn-circle btn-sm btn-xs"
                                                            href="{{route('pos.viewPosOrder',$order->id)}}">
                                                            <i class="fa-solid fa-download"></i>
                                                        </a>
                                                        <a href="{{ route('pos.orderDelete', $order->id) }}" id="delete"
                                                            class="btn btn-primary btn-icon btn-circle btn-sm btn-xs"
                                                            data-href="#">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>

                                                    <!--  <td class="text-end">
                                            <a href="#" class="btn btn-md rounded font-sm">Detail</a>
                                            <div class="dropdown">
                                                <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">View detail</a>
                                                    <a class="dropdown-item" href="#">Edit info</a>
                                                    <a class="dropdown-item text-danger" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </td> -->
                                                </tr>
                                            @endforeach
                                        @else
                                            <td>no order found</td>
                                        @endif

                                    </tbody>
                                </table>
                                {{-- <div class="pagination-area mt-25 mb-50">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            {{ $posOrder->links() }}
                                        </ul>
                                    </nav>
                                </div> --}}
                            </div>
                        </form>
                        <!-- table-responsive //end -->
                    </div>
                    <!-- card-body end// -->
                </div>
                <!-- card end// -->
            </div>
            <!-- <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">Filter by</h5>
                            <form>
                                <div class="mb-4">
                                    <label for="order_id" class="form-label">Order ID</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="order_id" />
                                </div>
                                <div class="mb-4">
                                    <label for="order_customer" class="form-label">Customer</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="order_customer" />
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Order Status</label>
                                    <select class="form-select">
                                        <option>Published</option>
                                        <option>Draft</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="order_total" class="form-label">Total</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="order_total" />
                                </div>
                                <div class="mb-4">
                                    <label for="order_created_date" class="form-label">Date Added</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="order_created_date" />
                                </div>
                                <div class="mb-4">
                                    <label for="order_modified_date" class="form-label">Date Modified</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="order_modified_date" />
                                </div>
                                <div class="mb-4">
                                    <label for="order_customer_1" class="form-label">Customer</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="order_customer_1" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div> -->
        </div>
    </section>

    @push('footer-script')
        {{-- <script type="text/javascript">
            $(function() {

                $('input[name="date"]').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    }
                });

                $('input[name="date"]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                        'MM/DD/YYYY'));
                });

                // $('input[name="date"]').on('cancel.daterangepicker', function(ev, picker) {
                //     $(this).val('');
                // });

                var start = moment().subtract(29, 'days');
                var end = moment();

                // start = '';
                // end = '';

                $('input[name="date"]').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    }
                });

                function cb(start, end) {
                    $('#reportrange').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }

                $('#reportrange').daterangepicker({
                    startDate: start,
                    endDate: end,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    }
                }, cb);

                cb(start, end);

            });
        </script> --}}

        <script>
            $(document).ready(function() {
                $('#reportrange').daterangepicker({
                    locale: {
                        format: 'DD-MM-Y'
                    },
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'This Year': [moment().startOf('year'), moment().endOf('year')]
                    }
                });
            });
        </script>
    @endpush
@endsection
