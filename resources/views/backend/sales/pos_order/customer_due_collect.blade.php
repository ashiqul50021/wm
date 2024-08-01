@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Customer Due Collect </h2>

            <div>
                {{-- <a href="{{ route('') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Add Product</a> --}}
            </div>
        </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{route('pos.dueCollectUpdate',$customerdue->id)}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Total Due</label>
                            <input type="text" id="totalDueAmount" readonly class="form-control"
                                value="{{ $customerdue->total_due ?? 'N/A' }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="collectedAmount">Collect Amount</label>
                            <input type="number" id="collectedAmount" name="collectedAmount" value="" placeholder="Enter Collected Amount"
                                class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="">Remaining Due</label>
                            <input type="number" id="remainingAmount" name="remainingAmount" readonly value="0" min="0"
                                class="form-control">
                        </div>
                        <input type="hidden" name="customer_id" value="{{$customerdue->customer->id ?? ''}}">
                    </div>
                    <button class="btn btn-primary mt-4" type="submit">Collect</button>
                </form>

            </div>
            <!-- card-body end// -->
        </div>
    </section>
@endsection


@push('footer-script')
    <script>
        $(document).on("keyup change", "#collectedAmount", function() {
            var value = parseFloat($(this).val()) || 0;
            var totalAmount = parseFloat($("#totalDueAmount").val()) || 0;
            value = Math.min(value,totalAmount)
            $(this).val(value);

            var remaining = totalAmount - value;
            $("#remainingAmount").val(remaining);


        })
    </script>
@endpush
