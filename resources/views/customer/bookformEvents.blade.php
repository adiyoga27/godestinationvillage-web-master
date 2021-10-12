@extends('customer/layout')
@section('content')
<style>
    label {
        font-weight: 400
    }
</style>
<!-- start page title area-->
<div class="page-title-area ptb-100">
    <div class="container">
        <div class="page-title-content">
            <h1>Reservation Form</h1>
            <ul>
                <li class="item"><a href="index.html">Home</a></li>
                <li class="item"><a href="#"><i class='bx bx-chevrons-right'></i>Reservation Form</a></li>
            </ul>
        </div>
    </div>
    <div class="bg-image">
        <img src="{{url('customer/img/page-title-area/bestoffer.jpg')}}" alt="Demo Image">
    </div>
</div>
<!-- end page title area -->
<section class="booking-section ptb-100 bg-light">
    <form action="{{ url('bookingEvents/sendEvent') }}" method="post">
        <section class="ftco-section ftco-degree-bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12  ftco-animate">
                        <h3>Event Information</h3>
                        <hr>
                    </div>
                    <div class="col-md-6  ftco-animate">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Event Name</label>
                            @csrf
                            <input type="text" name="eventname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="{{ $packages->name }}" readonly>
                            <input type="hidden" name="idevent" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="{{ $packages->id }}" readonly>

                        </div>
                    </div>
                    <div class="col-md-6  ftco-animate">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Type</label>
                            <input type="text" name="type" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="{{ $packages->category->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6  ftco-animate" style="display: none !important;">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Event</label>
                            <input type="text" name="eventname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="{{ $packages->name }}" readonly>
                        </div>
                    </div>
                    <div style="margin-top: 120px"></div>

                    <div class="col-md-12  ftco-animate">
                        <h4>Customer Information</h4>
                        <hr>
                    </div>
                    <?php ?>
                    <div class="col-md-6  ftco-animate">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Customer Name</label>
                            <input type="text" name="customername" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="@isset($user){{ $user->name }}@endisset" required>

                            <input type="hidden" name="customerid" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="@isset($user){{ $user->id }}@endisset" required>
                        </div>
                    </div>
                    <div class="col-md-6  ftco-animate">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="@isset($user){{ $user->email }}@endisset" required>
                        </div>
                    </div>
                    <div class="col-md-6  ftco-animate">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Address</label>
                            <input type="text" name="address" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="@isset($user){{ $user->address }}@endisset" required>
                        </div>
                    </div>
                    <div class="col-md-6  ftco-animate">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone</label>
                            <input type="text" name="phone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="@isset($user){{ $user->phone }}@endisset" required>
                        </div>
                    </div>
                    <div class="col-md-6  ftco-animate">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Gender</label>
                            <select name="gender" id="" class="form-control">
                                <option value="">Male</option>
                                <option value="">Female</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-top: 120px"></div>
                    <div class="col-md-12  ftco-animate">
                        <h4>Reservation Information</h4>
                        <hr>
                    </div>
                    @if($packages->is_paywish)
                    <div class="col-md-12  ftco-animate">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pay as you wish</b></label>
                            <div class="input-group">
                                <div class="btn btn-primary" style="border-radius:0; padding-top:10px;">Rp</div>

                                <input type="text" name="paywish" class="form-control price" id="exampleInputEmail1" aria-describedby="paywish" placeholder="" value="{{ $packages->price - $packages->price * 0.05 }}">


                            </div>
                        </div>
                        <hr>
                    </div>
                    @else
                    <div class="col-md-6  ftco-animate">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pax</label>
                            <input type="number" name="pax" min="1" value="1" class="form-control pax" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6  ftco-animate">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Price / Pax <b></b></label>
                            <div class="input-group">
                                <div class="btn btn-primary" style="border-radius:0; padding-top:10px;">Rp</div>

                                <input type="text" name="price" class="form-control price" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="{{ $packages->price }}" readonly>

                                <input type="hidden" name="totalprice" class="form-control totalprice" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="{{ $packages->price }}">

                            </div>
                        </div>
                    </div>
                    @endif


                    <div class="col-md-12  ftco-animate">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Special Note</label>
                            <input type="text" name="special_note" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                        </div>
                        <hr>
                    </div>
                    <div class="col-md-8  ftco-animate">
                    </div>
                    <!-- @if($packages->paywish)
                                            <div class="col-md-12  ftco-animate">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Pay as you wish</b></label>
                                                    <div class="input-group">
                                                        <div class="btn btn-primary" style="border-radius:0; padding-top:10px;">Rp</div>
                                                      
                                                            <input type="text" name="paywish" class="form-control price" id="exampleInputEmail1"
                                                                aria-describedby="paywish" placeholder=""
                                                                value="{{ $packages->price - $packages->price * 0.05 }}" >
                                                          
                                                      
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                            @endif -->
                    <div class="col-md-4  ftco-animate">

                        <h3 class="total">Total : Rp {{ number_format($packages->price,0,',','.') }}</h3>


                        <p>*Please check your form, because the order cannot be changed</p>
                        <button class="btn btn-lg btn-warning btn-block" id="pay-button">BOOK NOW</button>
                    </div>




                </div>
            </div>
        </section>
    </form>
</section>
@endsection()

@section('js')
<script>
    var result = '';
    $(function() {
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });

    //change
    $('.pax').keyup(function() {
        $('.totalprice').val($('.pax').val() * $('.price').val())
        result = formatRupiah(($('.pax').val() * $('.price').val()).toString(), '')
        $('.total').html("Total : Rp" + result)
    })

    $('.pax').change(function() {
        $('.totalprice').val($('.pax').val() * $('.price').val())
        result = formatRupiah(($('.pax').val() * $('.price').val()).toString(), '')
        $('.total').html("Total : Rp " + result)
    })

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }
</script>

@endsection