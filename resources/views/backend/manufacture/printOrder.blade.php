<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Print</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <style media="all">
        @page {
            margin: 0;
            padding: 0;
        }

        body {
            font-size: 0.575rem !important;
            font-weight: normal;
            padding: 0;
            margin: 0;
        }

        .gry-color *,
        .gry-color {
            color: #000;
        }

        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table.padding th {
            padding: .25rem .7rem;
        }

        table.padding td {
            padding: .25rem .7rem;
        }

        table.sm-padding td {
            padding: .1rem .7rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 1px solid #eceff4;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div>
        <div style="background: #eceff4;padding: 0px 20px;">
            @php
                $logo = get_setting('site_footer_logo');
            @endphp
            <div>
                @if ($logo != null)
                    <img style="font-size: 1.8rem; display: flex; height:60px; margin: 0 auto; padding: 0px 0px 10px 0px;"
                        src="{{ asset(get_setting('site_footer_logo')->value ?? ' ') }}" alt="{{ env('APP_NAME') }}">
                @else
                    <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}">
                @endif
            </div>
            <div style="font-size: 1.8rem;display: flex;justify-content: center">{{ get_setting('site_name')->value }}
            </div>

            <table>
                <tr>
                    <td style="text-align: center">{{ get_setting('business_address')->value }}</td>
                </tr>
                <tr>
                    <td class="text-center" style="text-align: center">Phone: {{ get_setting('phone')->value }}</td>
                </tr>
            </table>
            <hr>
        </div>

        <div style="padding: 0px 20px;">

            @if ($order != null)
                <table style="padding: 20px 0px;">
                    @if ($order->dealer_name != null)
                        <tr>
                            <td style="text-align: center"><span style="font-weight: 800; margin-left:5px;"> Order From
                                    (Dealer):
                                </span>
                                {{ $order->dealer_name ?? '' }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="text-align: center"><span style="font-weight: 800; margin-left:5px;"> Name: </span>
                            {{ $order->product->name_en }}</td>
                    </tr>
                    {{-- <tr>
                        <td style="text-align: center"><span style="font-weight: 800; margin-left:5px;"> Variant:</span>
                            {{ $order->product->variant_name }}</td>
                    </tr> --}}
                    <tr>
                        <td style="text-align: center"><span style="font-weight: 800; margin-left:5px;"> Manufacturing
                                Part:</span>

                            {{ $order->manufacture_part }}

                        </td>
                    </tr>
                    {{-- <tr>
                        <td style="text-align: center"><span style="font-weight: 800; margin-left:5px;"> Manufacturing
                                Quantity:</span> {{ $order->manufacture_quantity }}</td>
                    </tr> --}}

                    <tr>
                        {{-- @dd($product->user->name) --}}
                        <td style="text-align: center"><span style="font-weight: 800; margin-left:5px;"> Assaign
                                By:</span> {{ $order->user->name ?? '' }}</td>
                    </tr>


                </table>
                <div style="text-align: center; margin-bottom: 20px">
                    {!! DNS1D::getBarcodeSVG($order->manufacture_code, 'C39') !!}
                </div>

                <div style="text-align: center; font-weight: bold; font-size: 15px">
                    <p style="font-weight: bold;">
                        <span>Manufacture Quantity:</span> {{ $order->manufacture_quantity ?? '' }}
                    </p>
                </div>

                <img src="{{ asset($order->product->menu_facture_image) }}" class="img-sm" alt="Userpic"
                    style="display: flex;margin-left: auto;margin-right: auto;">
                <div class="mt-5">
                    <hr>
                    <p style="font-size: 15px; margin-left:5px;"><span
                            style="font-weight: 800">Note:</span>{{ $order->message ?? '' }}</p>
                    </tr>


            @endif
        </div>

        <div style="font-size: 13px; text-align: center; margin: 20px 0px; padding-bottom: 5px;">Developed By : <a
                target="_blank" style="text-decoration: none;font-weight: 700; margin-left: 5px;"
                href="https://classicit.com.bd"> Classic IT</a>
        </div>
    </div>


    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
