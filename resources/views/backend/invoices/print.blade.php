<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            outline: none;
            box-sizing: border-box;
            font-family: 'Roboto Slab', serif;
        }

        body {
            font-family: 'Roboto Slab', serif;
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            list-style: none;
        }

        p {
            margin: 0;
        }

        a,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Roboto Slab', serif;
        }

        /* global */
        .container {
            max-width: 1200px;
            width: 75%;
            margin: auto;
        }

        .theme__heading {
            text-align: center;
        }

        .theme__heading p {
            font-size: 30px;
            margin-bottom: 0;
            line-height: 1.5;
        }


        .header__section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
        }

        .header__content {
            text-align: center;
        }

        .header__content h2 {
            font-weight: 400;
            line-height: 1;
        }

        .header__content p {
            line-height: 1;
            font-size: 14px;
        }

        .header__content span {
            font-size: 12px;
        }

        .main_content h6 {
            text-align: center;
            margin-bottom: 0;
        }

        .person__info {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
        }

        .product__info__table table thead {
            width: max-content;
        }

        .product__info__table table {
            border: 1px solid #000;
        }

        .product__payment__info {
            display: flex;
            justify-content: space-between;
        }

        ul.amount__info li span:first-child {
            width: 150px;
            display: inline-block;
            text-align: end;
        }

        ul.amount__info li span:last-child {
            min-width: 70px;
            display: block;
            text-align: end;
        }

        ul.amount__info li {
            display: flex;
        }

        .product__info__table table {
            margin-bottom: 0;
        }

        .signature {
            display: flex;
            margin-top: 70px;
            justify-content: space-between;
        }

        .signature h6 {
            border-top: 1px solid #000;
        }

        section.footer__section h6 {
            text-align: center;
        }

        section.footer__section {
            border-top: 1px solid #000;
            position: fixed;
            bottom: 40px;
            max-width: 1115px;
            width: 90%;
        }

        .footer__content {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>



@php
    $logo = get_setting('site_logo');
   $business_address =  get_setting('business_address');
   $phone = get_setting('phone');
   $email = get_setting('email');
@endphp



<body>
    <div class="theme_main">
        <div class="container">

            <div class="woodmachinery" style="padding: 30px;">
                <header>
                    <section class="header__section">
                        <div class="header__logo">

                                @if ($logo != null)
                                    <img style="font-size: 1.8rem; display: flex; height:60px; margin: 0 auto;"
                                        src="{{ asset(get_setting('site_logo')->value ?? ' ') }}"
                                        alt="{{ env('APP_NAME') }}">
                                @else
                                    <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}">
                                @endif

                        </div>
                        <div class="header__content">
                            <h2>Wood Machinery and <br> Hardware</h2>
                            <p>{{ $business_address->value ?? 'Address not found' }}<br>
                                Phone Number {{ $phone->value ?? 'Phone Not Found' }}</p>
                            <span>Email: {{ $email->value ?? 'Email not found' }}</span>
                        </div>
                        <div></div>
                    </section>
                </header>

                <div class="main_content">
                    <h6>Invoice/Bill</h6>
                    <div class="person__info">
                        <ul>
                            <li>Invoice No : {{ $order->invoice_no ?? 'N/A' }}</li>
                            <li>Buyer Name : {{ $order->user->name ?? 'N/A' }}</li>
                            <li>Buyer Address : {{ $order->user->address ?? 'N/A' }}</li>
                            <li>Buyer Phone No : {{ $order->user->phone ?? 'N/A' }}</li>
                        </ul>
                        <ul>
                            <li>Date : {{ date('d-m-Y', strtotime($order->created_at)) }}</li>
                            {{-- <li>Sold By : Rafiqul</li> --}}
                            {{-- <li style="margin-top: 15px;">Remarks : Rafiqul</li> --}}
                        </ul>
                    </div>

                    <div class="product__info__table">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Product Price</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Product Discount</th>
                                    <th scope="col">Shipping Charge</th>
                                    <th scope="col">Amount</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->order_details as $key => $item)
                                <tr class="text-center">
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $item->product_name ?? 'N/A' }}</td>
                                    <td>{{ $item->price ?? 'N/A' }}</td>
                                    <td>{{ $item->qty ?? 'N/A' }}</td>
                                    <td>{{ $item->discount_1 ?? 'N/A' }}</td>
                                    <td>{{ $order->shipping_charge ?? 'N/A' }}</td>
                                    <td>{{ $order->grand_total ?? 'N/A' }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                        <div class="product__payment__info">
                            <ul>

                            </ul>
                            <ul class="amount__info">
                                <li>
                                    <span>Sub Total : </span>
                                    <span>{{ $order->sub_total ?? 'N/A' }}</span>
                                </li>
                                <li>
                                    <span>Products Discount : </span>
                                    <span>{{ $order->discount ?? '00' }}</span>
                                </li>
                                <li>
                                    <span>Add. Discount : </span>
                                    <span>{{ $order->additional_discount ?? '00' }}</span>
                                </li>
                                <li style="border-bottom: 1px solid #000;margin-top: 5px;">
                                    <span>Over All Discount : </span>
                                    <span>(-){{ $order->overall_discount ?? 'N/A' }}</span>
                                </li>
                                <li>
                                    <span>Grand Total:</span>
                                    <span>{{ $order->grand_total ?? 'N/A' }}</span>
                                </li>
                                {{-- <li style="border-bottom: 1px solid #000;margin-top: 5px;">
                                    <span>Received Amount : </span>
                                    <span>{{ $order->paid ?? 'N/A' }}</span>
                                </li> --}}
                                {{-- <li>
                                    <span>Due : </span>
                                    <span>{{ $order->due_amount ?? 'N/A' }}</span>
                                </li> --}}
                            </ul>
                        </div>

                        <div class="signature">
                            <h6>Receiver Signature </h6>
                            <h6>Manager Signature </h6>
                        </div>
                    </div>
                </div>

                <footer>
                    <section class="footer__section">
                        <h6>Our Main target is to satisfy customer</h6>
                        <div class="footer__content">
                            <h6>Developed by: Classic IT</h6>
                            <!-- <h6 style="display: flex;gap: 30px;"> -->

                            <!-- </h6> -->
                            <!-- <h6></h6> -->
                        </div>
                    </section>
                </footer>
            </div>

        </div>
        <!-- <div class=" text-center btn_text" id="btn_wrapper">
            <a class="btn btn-light text-capitalize border-0" id="print" data-mdb-ripple-color="dark"><i
                    class="fas fa-print text-primary"></i> Print</a>
        </div> -->
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>