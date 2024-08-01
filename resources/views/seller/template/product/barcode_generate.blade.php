@extends('seller.seller_master')
@section('seller')
    <div class="row">
        <div class="col-12">
            <div class="card-box m-4">
                <h4 class="mb-2">Print Item</h4>
                <div class="col-md-6 mb-4">
                    <label for="">Row</label>
                    <input type="number" name="row" id="codeRow" class="form-control" placeholder="Row" value="">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="">Column</label>
                    <input type="number" name="column" id="codeColumn" class="form-control" placeholder="Column"
                        value="">
                </div>
                <button type="button" onclick="ViewButton()" class="btn btn-secondary">View</button>
                <div class="header-title mb-4 mt-4">
                    <button class="btn btn-info btn-sm" type="button" onclick="printDivVendor('printableArea')">
                        <i class="fa fa-print"></i>
                        Print
                    </button>
                </div>

                <div class="panel-body" id="printableArea">


                </div>
            </div>
        </div>
    </div>
    @push('footer-script')
    <script>
        function printDivVendor(divName) {
            console.log("hello")
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }


        function ViewButton() {
            var row = parseFloat($("#codeRow").val()) || 0;
            var column = parseFloat($("#codeColumn").val()) || 0;
            console.log("row", row);
            console.log("column", column);

            var gridHtml = '';

            for (var i = 0; i < column; i++) {
                gridHtml += '<div>';
                for (var j = 0; j < row; j++) {
                    gridHtml += `
                <div class="col-md-2" style="padding: 10px; border: 1px solid #adadad; display:inline-block; line-height: 16px !important;" align="center">
                    <p>{{ $product->name_en ?? '' }}</p>
                    <p>{{ $product->purchase_code ?? '' }}</p>
                    <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($product->product_code, 'c128A', 1, 40, [1, 1, 1], true) . '"   />'; ?>
                    <br>
                    <small style="font-size: 8px !important;"><b>{{ $product->product_code ?? '' }}</b></small>
                    <p style="line-height: 12px !important; font-size: 8px !important;">
                        {{-- <b>Price: {{$product->sale_price}} </b> --}}
                    </p>
                </div>`;
                }
                gridHtml += '</div>';
            }

            // Append the generated grid to the #printableArea
            $("#printableArea").html(gridHtml);
        }
    </script>
    @endpush

@endsection
