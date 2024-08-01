@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Worker Payment</h2>
            <div class="">
                {{-- <a href="{{ route('worker.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Dealer
                    List</a> --}}
            </div>
        </div>
        <div class="row justify-content-center">

            <div class="col-sm-10">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('worker.workerPaymentUpdate', $workerBalance->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <p>Worker Name: <span>{{ $workerBalance->user->name }}</span></p>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="col-form-label col-md-4" style="font-weight: bold;"> Total
                                        Amount :
                                        <span class="text-danger"></span></label>
                                    <input class="form-control" id="totalBalance" type="text" name=""
                                        placeholder="Write Worker name"
                                        value="{{ old('name', $workerBalance->total_balance) }}">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="phone" class="col-form-label col-md-4" style="font-weight: bold;"> Paid
                                        Amount
                                        : <span class="text-danger">*</span></label>
                                    <input class="form-control" id="paidAmount" type="number" name="paidAmount"
                                        placeholder="Write Paid Amount" value="{{ old('paidAmount') }}">
                                    @error('paidAmount')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="email" class="col-form-label col-md-4" style="font-weight: bold;">
                                        Remaining Amount
                                        : <span class="text-danger">*</span></label>
                                    <input class="form-control" id="remainingAmount" type="number" name="remainingAmount"
                                        placeholder="Write Remaining Amount" value="{{ old('remainingAmount') }}">
                                    @error('remainingAmount')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!--<div class="col-md-6 mb-4">-->
                                <!--    <label for="email" class="col-form-label col-md-4" style="font-weight: bold;">-->
                                <!--        Collected By-->
                                <!--        : <span class="text-danger">*</span></label>-->
                                <!--    <select name="collected_by" id="" class="form-control">-->
                                <!--        @foreach($collects as $collect)-->
                                <!--        <option value="{{$collect->id}}">{{$collect->name}}</option>-->
                                <!--        @endforeach-->
                                <!--    </select>-->
                                <!--</div>-->

                            </div>


                            <div class="row mb-4 justify-content-sm-end">
                                <div class="col-lg-3 col-md-4 col-sm-5 col-6">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>
                        </form>
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
            var totalBalance = parseFloat($('#totalBalance').val());
            $('#paidAmount').keyup(function() {
                var paidAmount = parseFloat($(this).val()) || 0;
                paidAmount = Math.min(paidAmount, totalBalance);
                // console.log(paidAmount)
                var remainingAmount = totalBalance - paidAmount;
                $("#remainingAmount").val(remainingAmount);
            })
            console.log(totalBalance)
        });
    </script>
@endpush