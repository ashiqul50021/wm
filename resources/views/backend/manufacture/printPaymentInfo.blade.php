<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        *{
            box-sizing: border-box;
            font-family: Roboto, sans-serif;
        }

        body {
            font-size: 14px;
            color: #4c5258;
            letter-spacing: .5px;
            font-family: Roboto, sans-serif;
            background-color: #f7f8fa;
            overflow-x: hidden;
        }

        .invoice_image{
            width: 100px;
        }

        .invoice_customer_name p {
            color: #000;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .invoice_main{
            position: relative;
            z-index: 1;
        }

        .select2-area{
            height: 42px !important;
            padding: 5px 15px !important;
        }

        .invoice_ttile strong{
            font-size: 24px;
            color: #7928ca;
        }

        .invoice_customer_name {
            font-size: 18px;
            color: #7928ca;
            font-weight: 500;
            line-height: 22px;
        }

        .invoice_innfo_list {
            margin-bottom: 3px;
            font-size: 14px;
            font-weight: 400;
        }

        .table thead th, .table tbody td {
            padding: 8px 25px;
        }

        .table thead th {
            color: #fff;
            background-color: #7367f0;
        }

        .table-striped>tbody>tr:nth-of-type(odd)>* {
            --bs-table-accent-bg: transform;
            color: var(--bs-table-striped-color);
        }

        .table-striped>tbody>tr:nth-of-type(even)>* {
            --bs-table-accent-bg: var(--bs-table-striped-bg);
            color: var(--bs-table-striped-color);
        }

        .table>:not(caption)>*>* {
            padding: 8px 25px;
        }

        .invoice_block_title {
            font-size: 16px;
            color: #7928ca;
            font-weight: 500;
        }

        .invoice_block_text {
            color: #63696f;
            font-size: 14px;
        }

        .payment_info_title {
            font-weight: 500;
            min-width: 120px;
            display: inline-block;
            font-size: 14px;
        }

        .invoice_payment {
            background: rgba(0, 0, 0, 0.05);
            max-width: 300px;
            width: 100%;
            padding: 10px;
        }

        .payment_info_list ul li span{
            font-size: 14px;
        }

        .invoice_payment ul li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5px 10px;
        }

        .invoice_payment ul li:not(:last-child) {
            margin-bottom: 4px;
        }

        .invoice_payment ul li:last-child {
            background: #7367f0;
            color: #fff;
        }

        .btn_text a{
            font-size: 14px;
        }

    </style>
</head>
<body>
    <div class="card invoice_main">
        <div class="card-body">
            <div class="container" id="containerID">
                <div class= "mb-5 mt-3">
                    <div class="invoice_top mb-5">
                        <div class="row justify-content-between">
                            <div class="col-sm-6">
                                <div class="invoice_image">
                                    <img class="w-100" src="../assets/images/pharmecylog.png" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end invoice_ttile">
                                    <strong class=" fa-4x ms-0">Payment Invoice</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row gy-3 justify-content-between mb-5 align-items-end">
                        <div class="col-md-4">
                            <ul class="list-unstyled">
                                <li class="invoice_customer_name">Invoice to: <p>{{$manufactureLedger->user->name ?? ''}}</p></li>
                                <li class="invoice_innfo_list">{{$manufactureLedger->user->address ?? ''}}</li>
                                <li class="invoice_innfo_list">Email: {{$manufactureLedger->user->email ?? ''}}</li>
                                <li class="invoice_innfo_list">Phone: {{$manufactureLedger->user->phone ?? ''}}</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="text-md-center invoice_ttile invoice_ttile_middle">
                                <strong class=" fa-4x ms-0">Invoice</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <ul class="list-unstyled text-md-end">
                                <li class=""> <span class="fw-bold me-2 d-inline-block">Invoice ID:</span>{{$manufactureLedger->invoice_no}}</li>
                                <li class=""> <span class="fw-bold me-2 d-inline-block">Creation Date: </span>{{ $manufactureLedger->created_at->format('Y-m-d H:i') ?? '' }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row my-5 mx-1 justify-content-center table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead class="text-white">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Add Amount</th>
                                    <th scope="col">Paid Amount</th>
                                    <th scope="col">Remaining Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ $manufactureLedger->created_at->format('Y-m-d H:i') ?? '' }}</td>
                                    <td>{{$manufactureLedger->debit ?? ''}}</td>
                                    <td>{{$manufactureLedger->credit ?? ''}}</td>
                                    <td>{{$manufactureLedger->total ?? ''}}</td>
                                </tr>

                            </tbody>

                        </table>
                    </div>



                    <div class="row my-5">
                        <div class="col-md-6">
                            <p class="invoice_block_title text-black ms-3">Thank you for your purchase</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="invoice_block_title text-black text-md-end d-inline-block border-top">Singature</p>
                        </div>
                    </div>
                    <div class=" text-center btn_text" id="btn_wrapper">
                        <a class="btn btn-light text-capitalize border-0" id="print" data-mdb-ripple-color="dark"><i
                                class="fas fa-print text-primary"></i> Print</a>
                        {{-- <a href="{{route('pharmacy.pos.sale')}}" class="btn btn-light text-capitalize" data-mdb-ripple-color="dark"> Back To POS</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
let print = document.getElementById("print");
let btn_wrapper = document.getElementById("btn_wrapper");
let containerID = document.getElementById("containerID");

print.addEventListener("click", function() {
  btn_wrapper.style.display = "none";
  let printStyle = document.createElement("style");
  printStyle.innerHTML = `
    @media print {
      #containerID {
        max-width: 100%;
      }
      .table thead th {
            -webkit-print-color-adjust: exact;
        }

        .invoice_payment {
            -webkit-print-color-adjust: exact;
            background: rgba(0, 0, 0, 0.05);
            margin-left: auto;
        }

        .row {
            justify-content: space-between;
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(-1 * var(--bs-gutter-y));
            margin-right: calc(-.5 * var(--bs-gutter-x));
            margin-left: calc(-.5 * var(--bs-gutter-x));
        }

        .text-md-end {
            text-align: right !important;
        }

        .text-md-center{
            text-align: center !important;
        }

        .col-md-4 {
            flex: 0 0 auto;
            width: 33.33333333%;
        }

        .col-md-6 {
            flex: 0 0 auto;
            width: 50%;
        }
    }
  `;
  document.head.appendChild(printStyle);
  window.print();
});

window.addEventListener("afterprint", function() {
  btn_wrapper.style.display = "block";
  document.head.removeChild(printStyle);
});

    </script>
</body>
</html>
