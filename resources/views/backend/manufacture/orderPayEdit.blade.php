@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Order Payment Edit</h2>
            <div>
                <a href="{{ route('manufacture.paymentList') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>View
                    Payment List</a>
            </div>
        </div>
        </div>
        <form action="{{ route('manufacture.paymentUpdate',$payment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-12">

                            <input type="hidden" id="manufacture_id" name="manufacture_id" value="{{$payment->manufacture->id}}">
                            <div id="productInfo" class="mt-4">
                                <div>
                                    <table class="table">
                                        <tr>
                                            <th style="font-weight: bold;">Product Name</th>
                                            <th style="font-weight: bold;">Quantity</th>
                                            <th style="font-weight: bold;">Manufacture Part</th>
                                            <th style="font-weight: bold;">Manufacture Price</th>
                                            <th style="font-weight: bold;">Total Amount</th>
                                            <th style="font-weight: bold;">Paid Amount</th>
                                            <th style="font-weight: bold;">Due Amount</th>
                                        </tr>
                                        <tbody>
                                            <tr>

                                        <td>{{$payment->manufacture->product->name_en}}</td>
                                        <td>{{$payment->manufacture->manufacture_quantity}}</td>
                                        <td>{{$payment->manufacture->manufacture_part}}</td>
                                        <td>{{$payment->manufacture->manufacture_price}}</td>
                                        <td>{{$payment->total_price}}</td>
                                        <td>{{$payment->pay_amount}}</td>
                                        <td>{{$payment->due_amount}}</td>
                                        {{-- <td>${manufacture_quantity}</td>
                                        <td>${manufacture_part}</td>
                                        <td>${manufacture_price}</td>
                                        <td>${status}</td>
                                        <td>${total_price}</td> --}}
                                    </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4 ">
                            <label for="total_amount" class="col-form-label" style="font-weight: bold;">Total
                                Amount:</label>
                            <input class="form-control" id="total_amount" type="number" name="total_amount"
                                placeholder="Total Amount" readonly value="{{ old('total_amount',$payment->total_price) }}">
                        </div>

                        <div class="col-md-6 mb-4 ">
                            <label for="paid_amount" class="col-form-label" style="font-weight: bold;">Paid Amount:</label>
                            <input class="form-control" id="paid_amount" type="number" name="paid_amount"
                                placeholder="Paid Amount" value="{{ old('paid_amount',$payment->pay_amount) }}">
                        </div>

                        <div class="col-md-6 mb-4 ">
                            <label for="due_amount" class="col-form-label" style="font-weight: bold;">Due Amount:</label>
                            <input class="form-control" readonly id="due_amount" type="number" name="due_amount"
                                placeholder="Due Amount" min="0" value="{{ old('due_amount',$payment->due_amount) }}">
                        </div>

                    </div>
                    <div class="row mb-4 justify-content-sm-end">
                        <div class="col-lg-2 col-md-4 col-sm-5 col-6">
                            <input type="submit" class="btn btn-primary" value="Submit Payment">
                        </div>
                    </div>
                </div>
                <!-- card-body end// -->
            </div>
        </form>

    </section>

    @push('footer-script')
        <script>
            $(document).ready(function() {


                $("#paid_amount").keyup(function() {
                    var value = parseFloat($(this).val()) || 0;
                    var totalAmount = parseFloat($('#total_amount').val()) || 0;
                    var dueAmount = totalAmount - value;
                    console.log(value)
                    console.log(dueAmount)
                    if (dueAmount < 0) {
                        console.log('bd')
                        $("#due_amount").val(0);
                    } else {
                        $("#due_amount").val(dueAmount);
                    }

                })
            })
        </script>
    @endpush
@endsection
