<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
    <meta name="viewport"
        content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi">

    <meta property="og:site_name" content="Godevi">
    <meta property="og:title" content="{{ $title ?? 'GODEVI - Authentic Village Experiences' }}" />
    <meta property="og:description" content="{{ $content ?? 'Automatic Approve Payment' }}" />
    <meta property="og:image" itemprop="image" content="{{ $image ?? url('frontdata/images/bird.png') }}">
    <meta property="og:type" content="website" />
    <meta property="og:updated_time" content="1440432930" />

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Godesination Village') }}</title>
    <link rel="icon" href="{{ url('customer/img/favicon.png') }}" type="image/png" />


</head>

<body>
    <script src="{{env('MIDTRANS_URI_SANDBOX')}}" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        snap.pay('{{ $snapToken }}', {
            // Optional
            onSuccess: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log(result);

                window.location.href = '{{ $redirectURISuccess }}';
            },
            // Optional
            onPending: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);

                window.location.href = '{{ $redirectURIError }}';

                console.log(result);
            },
            // Optional
            onError: function(result) {

                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                window.location.href = '{{ $redirectURIError }}';

                console.log(result);
            },
            onClose: function(){
                /* You may add your own implementation here */
                window.location.href = '{{ $redirectURIError }}';
            }
        });
    </script>
</body>

</html>
