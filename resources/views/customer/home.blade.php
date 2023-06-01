@extends('customer/layout')

@section('content')
    <style>
        .owl-nav {
            display: none !important;
        }

        @media (max-width: 768px) {
            .home-banner-area img {
                height: 200px;
                object-fit: cover;
            }

            .home-banner-area .carousel-caption {
                display: block;
            }

            .home-banner-area .carousel-caption h1 {
                font-size: 20pt !important;
            }
        }

        .tours-section .slider-item::after {
            position: unset !important;
        }

    </style>
    <!-- start home banner area -->
    <div id="home" class="home-banner-area">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>

            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ url('storage/sliders/slide-1.jpg') }}" alt="First slide">
                    <div class="carousel-caption d-block">
                        <h1 class="h3-responsive" style="color:white;">Authentic Village Experience</h1>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ url('storage/sliders/slide-2.jpg') }}" alt="Second slide">
                    <div class="carousel-caption d-block">
                        <h1 class="h3-responsive" style="color:white;">Local Economic Improvement</h1>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ url('storage/sliders/slide-3.jpg') }}" alt="Third slide">
                    <div class="carousel-caption d-block">
                        <h1 class="h3-responsive" style="color:white;">Socially Responsible Tourism</h1>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ url('storage/sliders/slide-4.jpg') }}" alt="Third slide">
                    <div class="carousel-caption d-block">
                        <h1 class="h3-responsive" style="color:white;">Worry Free Travel Service</h1>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <!-- end home banner area -->


    <!-- start tours section -->
    <section id="tours" class="tours-section pt-100 pb-70">
        <div class="container">
            <div class="section-title">
                <h2>@lang('Explore Village')</h2>
                <p>@lang('Subtitle Explore Village')</p>
            </div>
            <div class="row no-wrap">

                <div class="col col-md-12">
                    <div class="tours-slider owl-carousel mb-30">
                        @foreach ($tag as $t)
                            <div class="slider-item" onclick="location.href ='{{ url('category-package/' . $t->id) }}';"
                                style="cursor:pointer">

                                {{-- <div class="image">

                                    <img src="{{ url('storage/tag/' . $t->image) }}"
                                        style="height:500px; 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                object-fit: cover;"
                                        alt="Demo Image" />

                                </div>

                                <div class="content">

                                    <div class="title">
                                        <h3>
                                            <a href="{{ url('village/' . $t->id) }}">{{ $t->name }}</a>
                                        </h3>
                                           <p>
                                            A wonderful little cottage right on the seashore - perfect for exploring.
                                        </p>

                                    </div>


                                </div> --}}
                                <div class="item-single mb-30">
                                    <div class="image">
                                        <img src="{{ url('storage/tag/' . $t->image) }}" alt="Demo Image">
                                    </div>
                                    <div class="content">

                                        <center>
                                            <h3>
                                                <a href="{{ url('category-package/' . $t->id) }}">{{ $t->name }}</a>
                                            </h3>
                                        </center>


                                        <p>
                                            {{ $t->desc }}
                                        </p>

                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end tour section -->

    <!-- start destination section -->
    <section id="destination" class="destination-section pt-100 pb-70 bg-light">
        <div class="container">
            <div class="section-title">
                <h2>@lang('Our Services')</h2>

            </div>
            <div class="col-md-12">
                <p style="text-align: center">@lang('Subtitle Our Services')
                </p>

            </div>

            <div class="row">
                <div class="container text-center my-3">
                    <div class="row mx-auto my-auto">
                        <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
                            <div class="carousel-inner w-100" role="listbox">
                                <div class="carousel-item active">
                                    <div class="col-lg-4 ">
                                        <div class="item-single mb-30" style="background-color: white">
                                            <a data-toggle="modal" data-target="#internship" href="#">
                                                <br>
                                                <img src="{{ url('customer/img/etc/internship.png') }}" width="100px"
                                                    alt="">
                                                <hr>

                                                <h3> @lang('Internship Program')
                                                </h3>
                                                <br>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item roundedcar">
                                    <div class="col-lg-4">
                                        <div class="item-single mb-30" style="background-color: white">
                                            <a data-toggle="modal" data-target="#perencanaan" href="#">
                                                <br>

                                                <img src="{{ url('customer/img/etc/perencanaan.png') }}" width="100px"
                                                    alt="">
                                                <hr>

                                                <h3><a href="#">@lang('Tourism Planning, Strategy and Revitalization')</a>
                                                </h3>
                                                <br>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="col-lg-4">
                                        <div class="item-single mb-30" style="background-color: white">
                                            <a data-toggle="modal" data-target="#projectmanagement" href="#">
                                                <br>

                                                <img src="{{ url('customer/img/etc/kajian.svg') }}" width="100px" alt="">
                                                <hr>

                                                <h3>@lang('Project Management')</h3>
                                                <br>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <div class="col-lg-4">
                                        <div class="item-single mb-30" style="background-color: white">
                                            <a data-toggle="modal" data-target="#branding" href="#">
                                                <br>

                                                <img src="{{ url('customer/img/etc/branding.svg') }}" width="100px"
                                                    alt="">
                                                <hr>

                                                <h3>Branding Destinasi dan <br> Pemasaran Digital
                                                </h3>
                                                <br>
                                            </a>

                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <div class="col-lg-4">
                                        <div class="item-single mb-30" style="background-color: white">
                                            <a data-toggle="modal" data-target="#tren" href="#">
                                                <br>

                                                <img src="{{ url('customer/img/etc/tren.svg') }}" width="100px" alt="">
                                                <hr>

                                                <h3>@lang('Consumer Trend and Tourism Insight')
                                                </h3>
                                                <br>
                                            </a>

                                        </div>
                                    </div>
                                </div>



                            </div>
                            <a class="carousel-control-prev w-auto" href="#recipeCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle"
                                    aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next w-auto" href="#recipeCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle"
                                    aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end destination section -->
    <!-- start blog section -->
    <section id="blog" class="blog-section pt-100 pb-70">
        <div class="container">
            <div class="section-title">
                <h2>@lang('Youtube Channel')</h2>
                <p>Travel has helped us to understand the meaning of life and it has helped us become better people. Each
                    time we travel, we see the world with new eyes.</p>
            </div>
            <!-- <div class="row">
                <div class="embed-responsive embed-responsive-21by9">
                    <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/videoseries?list=PLV0qBmInL2URngCAlIX5EERlJO4k7p6Zg"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div> -->

            <!-- <div class="row">
                <div class="col-md-8">
                    <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/videoseries?list=YOUR_PLAYLIST_ID" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="list-group" id="video-list"></ul>
                </div>
            </div> -->

            <div class="container">
                <h1>YouTube Playlist Videos</h1>
                <div class="row">
                <div class="col-md-8">
                    <div class="embed-responsive embed-responsive-16by9">
                    <iframe id="youtube-iframe" class="embed-responsive-item" src="https://www.youtube.com/embed/videoseries?list=YOUR_PLAYLIST_ID" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                </div>
            </div>

            <div class="container mt-5">
                <h3>Playlist Videos</h3>
                <div class="row" id="video-list"></div>
            </div>
        </div>
    </section>


    <!-- start blog section -->
    <section id="blog" class="blog-section pt-100 pb-70 bg-light">
        <div class="container">
            <div class="section-title">
                <h2>@lang('News Blogs')</h2>
                <p>@lang('Subtitle Blogs').</p>
            </div>
            <div class="row">
                @foreach ($recent_blog as $rec)

                    <div class="col-lg-6">
                        <div class="item-single item-big mb-30">
                            <div class="image">
                                <img src="{{ url('storage/blogs/' . $rec->post_thumbnail) }}"
                                    style="height:100%; width:100%; 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            object-fit: cover; !important"
                                    alt="{{ $rec->post_title }}" />
                            </div>
                            <div class="content">
                                <ul class="info-list">
                                    <li><i class='bx bx-calendar'></i> {{ $rec->created_at }}
                                    </li>
                                    <li><i class='bx bx-tag'></i>{{ $rec->post_tags }}</li>
                                </ul>
                                <h3>
                                    <a href="{{ url('blog/' . $rec->slug) }}">{{ $rec->post_title }}</a>
                                </h3>
                                <p>
                                    {!! \Illuminate\Support\Str::words($rec->post_content, 25, '...') !!}
                                </p>
                                <ul class="list">
                                    <li>
                                        <div class="author">
                                            <img src="{{ url('storage/users/' . $rec->user->avatar) }}" alt="{{$rec->user->name}}">
                                            <span> {{ $rec->user->name }}</span>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="{{ url('blog/' . $rec->slug) }}" class="btn-primary">Read More</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <!-- @break -->
                @endforeach

                <!-- <div class="col-lg-6">
                    <div class="row">
                        @php
                            $firstStep = true;
                        @endphp
                        @foreach ($recent_blog as $rec)
                            @php
                                if ($firstStep) {
                                    $firstStep = false;
                                    continue;
                                }
                            @endphp
                            <div class="col-lg-6">
                                <div class="item-single mb-30">
                                    <div class="image">
                                        <img src="{{ url('storage/blogs/' . $rec->post_thumbnail) }}" alt="Demo Image" />
                                    </div>
                                    <div class="content">
                                        <ul class="info-list">
                                            <li><i class='bx bx-calendar'></i> {{ $rec->created_at }}</li>
                                            <li><i class='bx bx-tag'></i>{{ $rec->post_tags }}</li>
                                        </ul>
                                        
                                        <h3>
                                            <a href="{{ url('blog/' . $rec->slug) }}">{{ $rec->post_title }}</a>
                                        </h3>
                                        <p>
                                    {!! \Illuminate\Support\Str::words($rec->post_content, 25, '...') !!}
                                </p>
                                        <ul class="list">
                                            <li>
                                                <div class="author">
                                                    <img src="{{ url('storage/users/' . $rec->user->avatar) }}"
                                                        alt="{{$rec->user->avatar}}">
                                                    <span>{{ $rec->user->name }}</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div> -->
            </div>
        </div>
    </section>

    <!-- start testimonial-section -->
    <section id="testimonial" class="testimonial-section ptb-100">
        <div class="container">
            <div class="section-title">
                <h2>@lang('What Our Clients Say')</h2>
                <p>Travel has helped us to understand the meaning of life and it has helped us become better people. Each
                    time we travel, we see the world with new eyes.</p>
            </div>
            <div class="row">
                <div class="col-lg-8 m-auto">
                    <div class="testimonial-slider owl-carousel">

                        @foreach ($reviews as $r)

                            <div class="slider-item">
                                <div class="client-img">
                                    <img src="{{ url('storage/reviews/' . $r->avatar) }}" alt="client-1"
                                        style=" object-fit: cover;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    width:80px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    height:80px;" />
                                </div>
                                <div class="content">
                                    <div class="client-info">
                                        <h3>{{ $r->name }}</h3>
                                        <span>{{ $r->job }}</span>
                                    </div>
                                    <div class="quote">
                                        <i class='bx bxs-quote-left'></i>
                                    </div>
                                    <p>
                                        {{ $r->comment }}.
                                    </p>
                                    <div class="review">
                                        @for ($i = 1; $i <= $r->rating; $i++)
                                            <i class='bx bxs-star'></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
            <div class='clients-img'>
                @foreach ($users as $item)
                    <img class="image image-{{ $loop->iteration }}" src="{{ url('storage/' . $item) }}" height="100px"
                        style="object-fit: cover; !important; width:100px ; !important" alt="Demo Image">

                @endforeach

            </div>
        </div>
        <div class="shape">
            <img src="customer/img/shape1.png" alt="Background Shape">
        </div>
    </section>
    <!-- end testimonial section -->


    <!-- end blog section -->
@endsection()

@section('js')

<script>
     $(document).ready(function() {
      // Fetch the video information from the YouTube Data API
      $.get(
        "https://www.googleapis.com/youtube/v3/playlistItems", {
          part: 'snippet',
          maxResults: 10,
          playlistId: 'PLV0qBmInL2URngCAlIX5EERlJO4k7p6Zg',
          key: 'AIzaSyC7kGh6mbXfjYLQMF_dS-WLRF2iscxg7_o'
        },
        function(data) {
          // Loop through the playlist items and create list items for each video
          for (var i = 0; i < data.items.length; i++) {
            var videoId = data.items[i].snippet.resourceId.videoId;
            var videoTitle = data.items[i].snippet.title;
            var videoThumbnail = data.items[i].snippet.thumbnails.default.url;

            // Create a list item with the video information
            var listItem = '<div class="col-md-3">' +
              '<div class="card">' +
              '<img src="' + videoThumbnail + '" class="card-img-top">' +
              '<div class="card-body">' +
              '<h5 class="card-title">' + videoTitle + '</h5>' +
              '<button class="btn btn-primary" onclick="changeVideo(\'' + videoId + '\')">Play</button>' +
              '</div>' +
              '</div>' +
              '</div>';

            // Append the list item to the video list
            $('#video-list').append(listItem);
          }
        }
      );
    });

    // Change the video within the embedded iframe
    function changeVideo(videoId) {
      var iframe = document.getElementById('youtube-iframe');
      iframe.src = 'https://www.youtube.com/embed/' + videoId;
    }
    
  </script>
@endsection()
