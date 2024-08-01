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
                <h2 class="content-title card-title">Pos Order due payment show</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <!-- card-header end// -->
                    <div class="card-body">
                        <div>

                        </div>
                        {{-- <form action=""></form> --}}
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Customer Name</td>
                                    <td>{{ $customerDuePayment->customer->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Total Due</td>
                                    <td>{{ $customerDuePayment->total_due ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Collect Due</td>
                                    <td>
                                        <input type="number" class="form-control CollectInput" placeholder="Collect Amount">
                                    </td>
                                </tr>

                                <tr>
                                    <td>Remaining Collected Amount</td>
                                    <td><input type="number" class="form-control collectedAmount" value="0" readonly>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>


                        <h4>Due Order List</h4>
                        <table class="table">
                            <thead>
                                <th>checked</th>
                                <th>Invoice No.</th>
                                <th>Amount</th>
                                <th>Paid Amount</th>
                                <th>Due Amount</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @if ($customerDuePayment->customerDueItem)
                                    @foreach ($customerDuePayment->customerDueItem as $key => $item)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input orderChecked" type="checkbox"
                                                        value="" id="{{ $item->posOrder->id }}">

                                                </div>
                                            </td>
                                            <td>{{ $item->posOrder->invoice_no ?? '' }}</td>
                                            <td>{{ $item->posOrder->total ?? '' }}</td>
                                            <td>{{ $item->posOrder->paid ?? '' }}</td>
                                            <td>{{ $item->posOrder->due ?? '' }}</td>
                                            <input type="hidden" name="status[]" class="status" id="{{ $item->posOrder->id }}" value="0">

                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                        <!-- table-responsive //end -->
                    </div>
                    <!-- card-body end// -->
                </div>
                <!-- card end// -->
            </div>

        </div>
        {{-- @dd($customerDuePayment->customerDueItem) --}}
    </section>

    @push('footer-script')
        <script>
            // collect input value
            var p = [];
            $(document).on("change", ".CollectInput", function() {
                var value = parseFloat($(this).val()) || 0;
                $('.collectedAmount').val(value);
                console.log("the value is", value)
            })

            $(document).on("change", ".orderChecked", function() {
                var orderId = $(this).attr('id');
                var collectedAmount = parseFloat($('.collectedAmount').val()) || 0;
                console.log("collected amount", collectedAmount)
                if (collectedAmount > 0) {

                    console.log("checked");
                    if ($(this).is(":checked")) {
                        console.log("id become", orderId)
                        console.log("after click checked");
                        updateChecked(orderId, collectedAmount)
                    }
                } else {
                    alert('Remaining Collected Amount Required!')
                    console.log("unchecked");
                    $(this).prop("checked", false);
                    console.log("unchecked");
                }
            })


            function updateChecked(orderId, collectedAmount) {
                console.log("order id from update checked", orderId)
                var url = "{{ route('pos.getOrderForDue', '') }}" + "/" + orderId;

                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'json',
                    success: function(data) {

                        console.log(data)
                        var dueAmount = parseFloat(data?.data?.due) || 0;
                        console.log(dueAmount)
                        if (collectedAmount > dueAmount) {
                            $(".status[id='" + orderId + "']").val(1);

                            var afterChecked = collectedAmount - dueAmount;
                            $('.collectedAmount').val(afterChecked);


                        } else {
                            $(".status[id='" + orderId + "']").val(2);

                            var afterChecked = dueAmount - collectedAmount;

                        }

                        status(orderId)
                    }
                });
            }

            function status(orderId) {
              var full =  $(".status[id='" + orderId + "']").val();
                console.log('value is', full)
            }

            function calculate(){
                var totalStatus
            }
        </script>
    @endpush
@endsection
