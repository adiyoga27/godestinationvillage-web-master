<html>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        var redirectUriEvent = 'window.location.href({{url("reservation-events/paid/$order[customer_email]")}})';
        var redirectUriTour = 'window.location.href({{url("reservation/paid/$order[customer_email]")}})';
alert('{{$redirectURI}}');
     
            snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result);    
                    alert('success');

                    window.location.href = '{{$redirectURI}}';
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    alert('pending');

                    window.location.href = '{{$redirectURI}}';

                    console.log(result);
                },
                // Optional
                onError: function(result) {
                    alert('error');

                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    window.location.href = '{{$redirectURI}}' ;

                    console.log(result);
                }
            });

       
    </script>
</html>