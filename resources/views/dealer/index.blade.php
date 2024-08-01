@extends('dealer.dealer_master')
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
@section('dealer')
 <section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Dashboard</h2>
            <p>Whole data about your business here</p>
        </div>


        <div>
            <a href="{{ route('dealer.pos.index') }}" class="btn btn-primary"><i class="text-muted material-icons md-post_add"></i>Pos</a>
        </div>
    </div>

    {{-- <div class="row ">
        <div class="col-sm-6 col-md-4">
          <div class="card text-white" >
            <div class="card-body d-flex justify-content-between">
                <div class="image">

                    <img class="" src="{{ asset('upload/order.png') }}" alt="">
                </div>
              <div class="text">
                <h3 class="">All Orders</h3>
                <h4 class="card-text">{{ count($all_requests) }}</h4>
              </div>
            </div>
          </div>
        </div>

      </div> --}}
    <div class="row">
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    {{-- <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-local_shipping"></i></span> --}}
                    <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-check_circle"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Confirmed Orders</h6>
                        <span>{{ count($confirmOrders) }}</span>
                        {{-- <span class="text-sm"> Excluding orders in transit </span> --}}
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    {{-- <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-local_shipping"></i></span> --}}
                    <span class="icon icon-sm rounded-circle bg-info-light"><i class="text-info material-icons md-shopping_cart"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Requested Orders</h6>
                        <span>{{ count($all_requests) }}</span>
                        {{-- <span class="text-sm"> Excluding orders in transit </span> --}}
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-warning material-icons md-qr_code"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Products</h6>
                        <span>{{ count($products) }}</span>

                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-local_shipping"></i></span>

                    <div class="text">
                        <h6 class="mb-1 card-title">Order Delivered</h6>
                        <span>{{ $confirmOrders->where('delivery_status', 'delivered')->count() }}</span>
                    </div>
                </article>
            </div>
        </div>
    </div>

    {{-- <div class="card mb-4">
        <header class="card-header">
            <h2 class="text-white">All History</h2>
        </header>
        <div class="card-body">
            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        </div>
    </div> --}}

</section>
@endsection

@push('footer-script')
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
@endpush
