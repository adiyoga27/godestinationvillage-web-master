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
                <h1>Book Form</h1>
                <ul>
                    <li class="item"><a href="index.html">Home</a></li>
                    <li class="item"><a href="#"><i class='bx bx-chevrons-right'></i>Book Form</a></li>
                </ul>
            </div>
        </div>
        <div class="bg-image">
            <img src="customer/img/page-title-area/blog-style3.jpg" alt="Demo Image">
        </div>
    </div>
    <!-- end page title area -->
    <section class="booking-section ptb-100 bg-light">
        <form action="{{ url('booking/send') }}" method="post">
            <section class="ftco-section ftco-degree-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12  ftco-animate">
                            <h3>Tour Packages Information</h3>
                            <hr>
                        </div>
                        <div class="col-md-6  ftco-animate">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tour Packages Name</label>
                                @csrf
                                <input type="text" name="tourname" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="" value="{{ $packages->name }}" readonly>
                                <input type="hidden" name="idtour" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="" value="{{ $packages->id }}" readonly>
                                <input type="hidden" name="village_id" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="" value="{{ $packages->user->id }}" required
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-6  ftco-animate">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Type</label>
                                <input type="text" name="type" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="" value="{{ $packages->category->name }}"
                                    required readonly>
                            </div>
                        </div>
                        <div class="col-md-6  ftco-animate">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Village</label>
                                <input type="text" name="village" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder=""
                                    value="{{ $packages->user->village_detail->village_name }}" required readonly>
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
                                <input type="text" name="customername" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder=""
                                    value="@isset($user){{ $user->name }}@endisset" required>

                                    <input type="hidden" name="customerid" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder=""
                                        value="@isset($user){{ $user->id }}@endisset" required>
                                    </div>
                                </div>
                                <div class="col-md-6  ftco-animate">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder=""
                                            value="@isset($user){{ $user->email }}@endisset" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6  ftco-animate">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Address</label>
                                            <input type="text" name="address" class="form-control" id="exampleInputEmail1"
                                                aria-describedby="emailHelp" placeholder=""
                                                value="@isset($user){{ $user->address }}@endisset" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6  ftco-animate">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Phone</label>
                                                <input type="text" name="phone" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" placeholder=""
                                                    value="@isset($user){{ $user->phone }}@endisset" required>
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
                                                <h4>Book Information</h4>
                                                <hr>
                                            </div>
                                            <div class="col-md-6  ftco-animate">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Pax</label>
                                                    <input type="number" name="pax" min="1" value="1" class="form-control pax"
                                                        id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6  ftco-animate">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Price / Pax <b>(Disc 5% For Member)</b></label>
                                                    <div class="input-group">
                                                        <div class="btn btn-primary" style="border-radius:0; padding-top:10px;">Rp</div>
                                                        @guest
                                                            <input type="text" name="price" class="form-control price" id="exampleInputEmail1"
                                                                aria-describedby="emailHelp" placeholder="" value="{{ $packages->price }}"
                                                                readonly>

                                                            <input type="hidden" name="totalprice" class="form-control totalprice"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=""
                                                                value="{{ $packages->price }}" required>
                                                        @else
                                                            <input type="text" name="price" class="form-control price" id="exampleInputEmail1"
                                                                aria-describedby="emailHelp" placeholder=""
                                                                value="{{ $packages->price - $packages->price * 0.05 }}" readonly>
                                                            <input type="hidden" name="totalprice" class="form-control totalprice"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=""
                                                                value="{{ $packages->price - $packages->price * 0.05 }}" required>
                                                        @endguest
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($packages->category->name != 'Virtual Tour')
                                            <div class="col-md-12  ftco-animate">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Date</label>
                                                    <input type="datetime-local" name="checkin_date" class="form-control"
                                                        aria-describedby="emailHelp" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6  ftco-animate">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Pick up location</label>
                                                    <input type="datetime-local" name="pickup" class="form-control" aria-describedby="emailHelp"
                                                        placeholder="" required>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-md-6  ftco-animate">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Hotel/Villa/Guest House Name</label>
                                                    <input type="text" name="pickupname" class="form-control" id="exampleInputEmail1"
                                                        aria-describedby="emailHelp" placeholder="" required>
                                                </div>
                                                <hr>
                                            </div>
                                            @endif
                                           
                                            <div class="col-md-12  ftco-animate">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Special Note</label>
                                                    <input type="text" name="special_note" class="form-control" id="exampleInputEmail1"
                                                        aria-describedby="emailHelp" placeholder="">
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-md-8  ftco-animate">
                                            </div>
                                            <div class="col-md-4  ftco-animate">
                                                @guest
                                                    <h3 class="total">Total : Rp {{ number_format($packages->price,0,',','.') }}</h3>
                                                @else
                                                    <h3 class="total">Total : Rp {{ number_format($packages->price - $packages->price * 0.05,0,',','.') }} </h3>
                                                @endguest
                                                <p>*Please check your form, because the order cannot be changed</p>
                                                <button class="btn btn-lg btn-warning btn-block">BOOK NOW</button>
                                            </div>




                                        </div>
                                    </div>
                                </section>
                            </form>
                        </section>
                    @endsection()

                    @section('js')
                        <script>
                            $(function() {
                                $("#datepicker").datepicker({
                                    dateFormat: 'yy-mm-dd'
                                });
                            });

                            //change
                            $('.pax').keyup(function() {
                                $('.totalprice').val($('.pax').val() * $('.price').val())
                                $('.total').html("Total : Rp" + $('.pax').val() * $('.price').val())
                            })

                            $('.pax').change(function() {
                                $('.totalprice').val($('.pax').val() * $('.price').val())
                                $('.total').html("Total : Rp" + $('.pax').val() * $('.price').val())
                            })

                        </script>
                    @endsection
