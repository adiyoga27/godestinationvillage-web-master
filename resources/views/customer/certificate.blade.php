@extends('customer/layout')
@section('content')
    <!-- start page title area-->
    <div class="page-title-area ptb-100">
        <div class="container">
            <div class="page-title-content">
                <h1>{{$certificate->category}}</h1>
                <ul>
                    <li class="item"><a href="index.html">Surat</a></li>
                    <li class="item"><a href="#"><i class='bx bx-chevrons-right'></i>Details</a></li>
                </ul>
            </div>
        </div>
        <div class="bg-image">
            <img src="{{ url('customer/img/page-title-area/blog-style3.jpg') }}" alt=" Demo Image">
        </div>
    </div>
    <!-- start blog details section -->
    <section id="about" class="about-section about-style-three ptb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-10 m-auto">
                    <div class="about-content">
                       
                        <div class="col-md-6 m-auto">
                            <div class="row">
                                    <div class="content-list">
                                        <h6>No Surat :</h6>
                                    </div>
                                <hr>
                                <p>{{$certificate->reference_number}}</p>
                            </div>

                        </div>
                        <div class="col-md-6 m-auto">
                            <div class="row">
                                    <div class="content-list">
                                        <h6>Tanggal :</h6>
                                    </div>
                                <hr>
                                <p>{{$certificate->date_at}}</p>
                            </div>
                        </div>
                     

                        <div class="col-md-6 m-auto">
                            <div class="row">
                                    <div class="content-list">
                                        <h6>Perihal :</h6>
                                    </div>
                                <hr>
                                <p>{{$certificate->regarding}}</p>
                            </div>
                        </div>                        
                        <div class="col-md-6 m-auto">
                            <div class="row">
                                    <div class="Ditujukan Kepada">
                                        <h6>Ditunjukan Kepada :</h6>
                                    </div>
                                <hr>
                                <p>{{$certificate->addressed_to}}</p>
                            </div>
                        </div> 
                        <div class="col-md-6 m-auto">
                            <div class="row">
                                    <div class="Ditujukan Kepada">
                                        <h6>Penanda Tangan :</h6>
                                    </div>
                                <hr>
                                <p>{{$certificate->signer}}</p>
                            </div>
                        </div> 
                        <div class="col-md-6 m-auto">
                            <div class="row">
                                    <div class="Ditujukan Kepada">
                                        <h6>Jabatan  :</h6>
                                    </div>
                                <hr>
                                <p>{{$certificate->departemen}}</p>
                            </div>
                        </div>                        
                        <br>
                        <div class="about-btn">
                            <a href="{{url('storage/certification/'.$certificate->file)}}" class="btn-primary">Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shape shape-1"><img src="{{url('customer/img/shape1.png')}}" alt="Background Shape"></div>
        <div class="shape shape-2"><img src="{{url('customer/img/shape2.png')}}" alt="Background Shape"></div>
        <div class="shape shape-3"><img src="{{url('customer/img/shape3.png')}}" alt="Background Shape"></div>
        <div class="shape shape-4"><img src="{{url('customer/img/shape4.png')}}" alt="Background Shape"></div>
    </section>
    <script>
        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
        /*
        var disqus_config = function () {
        this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
        this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
        */
        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document,
                s = d.createElement('script');
            s.src = 'https://godestinationvillage.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <!-- end blog details section -->
@endsection
