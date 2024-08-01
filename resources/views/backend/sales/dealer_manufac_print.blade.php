<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Image Print</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
	<style media="all">
        @page {
			margin: 0;
			padding:0;
		}
		body{
			font-size: 0.575rem !important;
            font-weight: normal;
			padding:0;
			margin:0; 
		}
		.gry-color *,
		.gry-color{
			color:#000;
		}
		table{
			width: 100%;
		}
		table th{
			font-weight: normal;
		}
		table.padding th{
			padding: .25rem .7rem;
		}
		table.padding td{
			padding: .25rem .7rem;
		}
		table.sm-padding td{
			padding: .1rem .7rem;
		}
		.border-bottom td,
		.border-bottom th{
			border-bottom:1px solid #eceff4;
		}
		.text-left{
			text-align:left;
		}
		.text-right{
			text-align:right;
		}
	</style>
</head>
<body>
	<div>
		<div style="background: #eceff4;padding: 0px 20px;">
		    @php
                $logo = get_setting('site_footer_logo');
            @endphp
            @if($logo != null)
                <img style="font-size: 1.8rem; display: flex; height:60px; margin: 0 auto; padding: 0px 0px 10px 0px;" src="{{ asset(get_setting('site_footer_logo')->value ?? ' ') }}" alt="{{ env('APP_NAME') }}">
            @else
                <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}">
            @endif
			<div style="font-size: 1.8rem;display: flex;justify-content: center">{{ get_setting('site_name')->value }}</div>
			<table>
				<tr>
					{{-- <td style="font-size: 1rem;" class="text-right strong">INVOICE</td> --}}
				</tr>
			</table>
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
            @if($dealer_request_product != null)
                <table style="padding: 20px 0px;">
                    <tr>
                        <td style="text-align: center"><span style="font-weight: 800; margin-left:5px;">Dealer Name: </span> {{$dealer->name}}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><span style="font-weight: 800; margin-left:5px;">Dealer Address: </span> {{$dealer->address}}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><span style="font-weight: 800; margin-left:5px;">Product Name: </span> {{ $product->name_en }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><span style="font-weight: 800; margin-left:5px;"> Variant:</span> {{ $dealer_request_product->variation }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><span style="font-weight: 800; margin-left:5px;"> Qty:</span> {{ $dealer_request_product->qty }}</td>
                    </tr>
                </table>
                <img src="{{ asset($product_stock->manufimage) }}" class="img-sm" alt="Userpic" style="display: flex;margin-left: auto;margin-right: auto;">
            @endif
		</div>
        <div style="font-size: 13px; text-align: center; margin: 20px 0px; padding-bottom: 5px;">Developed By : <a target="_blank" style="text-decoration: none;font-weight: 700; margin-left: 5px;" href="https://classicit.com.bd">Classic IT</a>
        </div>
	</div>
</body>
</html>

<script>
    window.onload = function() {
        window.print();
    };
</script>