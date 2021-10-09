@extends('customer/layout',array(
'title' => 'Best Offers - GODEVI',
)
)
@section('content')
    <!-- start page title area-->
    <div class="page-title-area ptb-100">
        <div data-aos="fade-up" data-aos-offset="100" data-aos-duration="500" class="container aos-init aos-animate">
            <div class="page-title-content">
                <h1>@lang('HomeStay')</h1>
                <ul>
                    <li class="item"><a href="/">@lang('Home')</a></li>
                    <li class="item"><a href="#"><i class="bx bx-chevrons-right"></i>@lang('HomeStay')</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="bg-image"><img src="{{ url('customer/img/page-title-area/homestay.jpg') }}" alt="Image"></div>
    </div>
    <!-- end page title area -->
    <!-- start top destination section -->
    <section id="top-destination" class="top-destination-section pt-100 pb-70 bg-light">
        <div class="container">
            <div class="section-title">
                <h2>COMING SOON</h2>
                <p> Stay tuned for more details, <br>Instagram : <a href="https://www.instagram.com/godestinationvillage/">@godestinationvillage</a> <br> Phone : +62 82 236 803301</p>
            </div>
            <div class="row">
                @foreach ($packages as $pack)

                    <div class="col-lg-4 col-md-6">
                        <div class="item-single mb-50">
                            <div class="image">
                                <img src="{{ url('storage/packages/' . $pack->default_img) }}" alt="{{ $pack->name }}">
                            </div>
                            <div class="content">
                                <span class="location"><i class='bx bx-map'></i>{{ $pack->vil_name }}</span>
                                <h3>
                                    <a href="{{ url('tour-packages/' . $pack->id) }}">{{ $pack->name }}</a>
                                </h3>

                                <p>
                                    {{ strip_tags(substr($pack->desc, 0, 100)) }}.
                                </p>
                                <hr>
                                <ul class="list">
                                    <li><i class='bx bx-time'></i>{{ $pack->cat_name }}</li>
                                    <li><i class='bx bx-group'></i>10+</li>
                                    <li>${{ $pack->price }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                @endforeach


            </div>
        </div>
    </section>
    <!-- end top destination section -->
    <!-- end our tour section -->


@endsection()
