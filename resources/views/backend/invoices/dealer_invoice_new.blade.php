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
            width: 100%;
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
            margin-left: -130px;
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
            bottom: 20px;
            max-width: 1115px;
            width: 100%;
        }

        .footer__content {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>


@php
    $logo = get_setting('site_logo');
    $business_address = get_setting('business_address');
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
                <h6>Dealer Invoice/Bill</h6>
                <div class="person__info">
                    <ul>
                        <li>Invoice No : {{ $dealerConfirm->invoice_no ?? 'N/A' }}</li>
                        <li>Dealer Name : {{ $dealerConfirm->user->name ?? 'N/A' }}</li>
                        <li>Dealer Address : {{ $dealerConfirm->user->address ?? 'N/A' }}</li>
                        <li>Dealer Phone No : {{ $dealerConfirm->user->phone ?? 'N/A' }}</li>
                    </ul>
                    <ul>
                        <li>Date : {{ date('d-m-Y', strtotime($dealerConfirm->created_at)) }}</li>
                        {{-- <li>Sold By : Rafiqul</li> --}}
                        {{-- <li style="margin-top: 15px;">Remarks : Rafiqul</li> --}}
                    </ul>
                </div>

                <div class="product__info__table">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="padding: 0; text-align: center" scope="col">SL No</th>
                            <th style="margin: 0; padding: 5px; text-align: center;">Product Name</th>
                            <th style="padding: 0;margin: 0; text-align: center" scope="col">Req. Qty</th>
                            <th style="padding: 0;margin: 0; text-align: center" scope="col">Conf. Qty</th>
                            <th style="padding: 0;margin: 0; text-align: center" scope="col">Unit Price</th>
                            <th style="padding: 0;margin: 0; text-align: center" scope="col">Total Price</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($dealerConfirm->requestConfirmProduct as $key => $item)
                            <tr>
                                <th style="padding: 0; text-align: center">{{ $key + 1 }}</th>
                                <td style="margin: 0; padding: 5px; text-align: start;">
                                    {{ $item->product->name_en ?? 'N/A' }}</td>
                                <td style="padding: 0;margin: 0; text-align: center">
                                    {{ $item->request_qty ?? 'N/A' }}</td>
                                <td style="padding: 0;margin: 0; text-align: center">
                                    {{ $item->confirm_qty ?? 'N/A' }}</td>
                                <td style="padding: 0;margin: 0; text-align: center">
                                    {{ $item->unit_price ?? 'N/A' }}</td>
                                <td style="padding: 0;margin: 0; text-align: center">
                                    {{ number_format($item->total_price ?? 'N/A') }}</td>

                            </tr>
                        @endforeach


                        </tbody>
                    </table>

                    <div class="product__payment__info">
                        <ul>
                            @php
                                function numberToWords($num = false)
                                    {
                                     $num = str_replace(array(',', ' '), '' , trim($num));
                                     if(! $num) {
                                         return false;
                                     }
                                     $num = (int) $num;
                                     $words = array();
                                     $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
                                         'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
                                     );
                                     $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
                                     $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
                                         'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
                                         'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
                                     );
                                     $num_length = strlen($num);
                                     $levels = (int) (($num_length + 2) / 3);
                                     $max_length = $levels * 3;
                                     $num = substr('00' . $num, -$max_length);
                                     $num_levels = str_split($num, 3);
                                     for ($i = 0; $i < count($num_levels); $i++) {
                                         $levels--;
                                         $hundreds = (int) ($num_levels[$i] / 100);
                                         $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
                                         $tens = (int) ($num_levels[$i] % 100);
                                         $singles = '';
                                         if ( $tens < 20 ) {
                                             $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
                                         } else {
                                             $tens = (int)($tens / 10);
                                             $tens = ' ' . $list2[$tens] . ' ';
                                             $singles = (int) ($num_levels[$i] % 10);
                                             $singles = ' ' . $list1[$singles] . ' ';
                                         }
                                         $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
                                     } //end for loop
                                     $commas = count($words);
                                     if ($commas > 1) {
                                         $commas = $commas - 1;
                                     }
                                     return implode(' ', $words);
                                    }

                                 $amountInWords = ucwords(numberToWords($dealerConfirm->total_amount));

                            @endphp


                            <li>
                                <span style="font-weight: bold">Total In Words : </span>
                                <span>{{ $amountInWords ?? '' }} Taka</span>

                            </li>
                            <li class="mt-5">
                                <span style="font-weight: bold">Description:</span>
                                {{ $dealerConfirm->note ?? 'N/A' }}
                            </li>
                        </ul>
                        <ul class="amount__info">
                            <li>
                                <span>Total : </span>
                                <span>{{ number_format($dealerConfirm->total_amount ?? 'N/A') }}</span>
                            </li>
                            <li style="border-bottom: 1px solid #000;margin-top: 5px;">
                                <span>Received Amount : </span>
                                <span>{{ $posOrder->paid ?? 'N/A' }}</span>
                            </li>
                            <li>
                                <span>Due : </span>
                                <span>{{ $posOrder->due ?? 'N/A' }}</span>
                            </li>
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
    window.onload = function () {
        window.print();
    }
</script>
</body>

</html>