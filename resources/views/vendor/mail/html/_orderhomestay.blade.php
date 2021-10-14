@component('mail::message')
	{!! $message !!} <br /><br />
	<strong>Order No.</strong> : {{ $data->code }}><br />
	<span class="float-right"> <strong>Order Date :</strong> {{ date('d/m/Y', strtotime($data->created_at))}}</span><br />
	<hr />
	<strong>Arrival Date :</strong> {{ date('d/m/Y', strtotime($data->checkin_date))}}</span><br /><br />
	<table style="width: 100%;">
		<tr>
			<td style="width: 50%; padding: 0px; vertical-align: top;">
				CUSTOMER : <br />
				<strong>{{$data->customer_name}}</strong> <br />
				{{$data->customer_address}} <br />
				Email: {{$data->customer_email}} <br />
				Phone: {{$data->customer_phone}} <br />
			</td>
			<td style="width: 50%; padding: 0px; vertical-align: top;">
				<strong>Godestiantion Village</strong><br />
				Jln Wr Supratman No. 302 Denpasar Timur, Bali <br />
				Website: {{env('APP_URL')}} | Email : {{env('APP_EMAIL')}} <br />
				Phone : {{env('APP_PHONE')}} <br /><br />
				PAYMENT : <br>
			<strong>{{ str_replace('_', ' ', strtoupper($data->payment_type)) }}</strong> <br />
				STATUS :<br>
				<strong>
					@if($data->payment_status == 'pending') PENDING @elseif($data->payment_status == 'success') SUCCESS @elseif($data->payment_status == 'cancel') DECLINED @endif <br />
			</td>
		</tr>
	</table>
	<br>
	{!! $data->special_note !!}<br /><br />
	@component('mail::table')
	|                      |   Transaction Detail   |                      |
	|----------------------|------------------------|----------------------|
	|  Name of Homestay    |                        | {{ $data->homestay_name }} |
	|  People(s)           |                        | {{ $data->pax }} Pax |
	|  Price of Homestay   |                        | Rp {{ number_format($data->homestay_price, 2,'.',',') }} |
	|  Discount            |                        | Rp {{ number_format($data->homestay_discount, 2,'.',',') }} |
	| <strong>Payment Total</strong>  |                        | <strong>Rp {{ number_format($data->total_payment, 2,'.',',') }}</strong> |
	@endcomponent


	<br /> Click <a href="{{ url('invoice-homestay/'. $data->uuid) }}">this link</a> for download your 
	@if($data->payment_status == 'success')
	{{'voucher'}}
	@else($data->payment_status == 'pending')
	{{'invoice'}}
	@endif
@endcomponent


