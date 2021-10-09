@component('mail::message')
{!! $message !!} <br /><br />
Order No. : <strong>{{ $data->code }}</strong><br />
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
			<strong>Godevi</strong><br />
			Jln Wr Supratman No. 302 Denpasar Timur, Bali <br />
			Website: www.godevi.id | Email : hello@godevi.id <br />
			Phone : 081938834675 <br /><br />
			PAYMENT : <br>
			<strong>{{ str_replace('_', ' ', strtoupper($data->payment_type)) }}</strong> <br />
			@if($data->payment_status == 'pending') PENDING @elseif($data->payment_status == 'success') SUCCESS @elseif($data->payment_status == 'cancel') DECLINED @endif <br />
			@if($data->payment_type == 'bank_transfer')<strong>{{$data->bank_account->bank_name}} {{$data->bank_account->bank_acc_no}}</strong> a/n {{ $data->bank_account->bank_acc_name }}@endif
		</td>
	</tr>
</table>
<br>
{!! $data->special_note !!} <br /><br />

@component('mail::table')
	|  Name of Tourism Village  | {{ $data->village_name }} |
	| ------------------------- | ------------------------- |
	|  Name of Tour Package  | {{ $data->package_name }} |
	|  People(s)  | {{ $data->pax }} Pax |
	|  Price of Tour Package  | Rp {{ number_format($data->package_price, 2,'.',',') }} |
	|  Discount  | Rp {{ number_format($data->package_discount, 2,'.',',') }} |
	|  <strong>Payment Total</strong>  | <strong>Rp {{ number_format($data->total_payment, 2,'.',',') }}</strong> |
@endcomponent

<br /> Click <a href="{{ url('invoice/'.$data->id) }}">this link</a> for download your 
@if($data->payment_status == 'success')
{{'voucher'}}
@else($data->payment_status == 'pending')
{{'invoice'}}
@endif
@endcomponent