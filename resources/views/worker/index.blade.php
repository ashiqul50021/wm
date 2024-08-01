@extends('worker.worker_master')
@push('css')
<script type="text/javascript">
window.onload = function() {
var options = {
    exportEnabled: true,
    animationEnabled: true,
    title:{
        text: "{{ get_setting('site_name')->value ?? ''}}"
    },
    legend:{
        horizontalAlign: "right",
        verticalAlign: "center"
    },
    data: [{
        type: "pie",
        showInLegend: true,
        toolTipContent: "<b>{name}</b>: {y} (#percent)",
        indexLabel: "{name}",
        legendText: "{name} (#percent)",
        indexLabelPlacement: "inside",
        dataPoints: [
            { y: 6, name: "Pending" },
            { y: 9, name: "Prossecing" },
            { y: 10, name: "Delivery" },
            { y: 12, name: "Sales" },
            { y: 5, name: "Others"},
            { y: 6, name: "Utilities" }
        ]
    }]
};
$("#chartContainer").CanvasJSChart(options);

}
</script>
@endpush
@section('worker')
 <section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Dashboard</h2>
            <p>Whole data about your business here</p>
        </div>
        {{-- <div>
            <a href="{{ route('dealer.pos.index') }}" class="btn btn-primary"><i class="text-muted material-icons md-post_add"></i>Pos</a>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light"><i class="text-primary material-icons md-monetization_on"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Total Balance</h6>

                        @if ($workerBalance)
                        <span>৳ {{ number_format($workerBalance->total_balance, 2 )  }}</span>
                        @endif
                    </div>
                </article>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-local_shipping"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">all Orders</h6>
                        <span>{{ number_format($allOrders ?? '00') }}</span>

                    </div>
                </article>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-local_shipping"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Completed Orders</h6>
                        <span>{{ number_format($complatedOrder) }}</span>

                    </div>
                </article>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-warning material-icons md-qr_code"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Pending Order</h6>
                        <span>{{ number_format($pendingOrder) }}</span>
                        {{-- <span class="text-sm"> In {{ number_format($categoryCount->total_categories) }} Categories </span> --}}
                    </div>
                </article>
            </div>
        </div>

    </div>



</section>
@endsection

@push('footer-script')
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
@endpush
