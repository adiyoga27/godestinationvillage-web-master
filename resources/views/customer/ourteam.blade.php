@extends('customer/layout')
@section('content')

    <!-- start page title area-->
    <div class="page-title-area ptb-100">
        <div class="container">
            <div class="page-title-content">
                <h1>Our Team</h1>
                <ul>
                    <li class="item"><a href="index.html">Home</a></li>
                    <li class="item"><a href="team.html"><i class='bx bx-chevrons-right'></i>Team</a></li>
                </ul>
            </div>
        </div>
        <div class="bg-image">
            <img src="customer/img/page-title-area/team.jpg" alt="Demo Image">
        </div>
    </div>
    <!-- end page title area -->

    <!-- start team section -->
    <section id="team" class="team-section ptb-100">
        <div class="container">
            <div class="section-title">
                <h2>Our Team & Guide</h2>
                <p>Travel has helped us to understand the meaning of life and it has helped us become better people. Each
                    time we travel, we see the world with new eyes.</p>
            </div>
            <div class="row">
                <div class="py-5 team3">
              
                      <div class="row">
                        @for ($i = 1; $i < 5; $i++)
                            
                        <!-- column  -->
                        <div class="col-lg-4 mb-4">
                            <!-- Row -->
                            <div class="item-single ">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="https://www.wrappixel.com/demos/ui-kit/wrapkit/assets/images/team/t1.jpg" alt="wrapkit" class="img-fluid" />
                                </div>
                                <div class="col-md-12">
                                        <center>
                                        <h5 class="mt-4 font-weight-medium mb-0">Michael Doe</h5>
                                        <h6 class="subtitle">Property Specialist</h6>
                                        </center>
                                        <div class="ml-4 mr-4">
                                            <p>Gian is the founder of Godevi. With a strong academic background, Gian serves as a lecturer at Udayana University and has previously taught at Bali Tourism Polytechnic. This combination of academic and practical experience positions Gian as a highly knowledgeable professional in the field of tourism.

                                                Additionally, Gian has hands-on experience in the industry, having successfully developed a travel agency called KK Tour Indonesia. This practical experience provides Gian with valuable insights into the operational aspects of the tourism sector.
                                                
                                                As the founder of Godevi, Gian leverages their academic expertise, practical knowledge, and entrepreneurial spirit to provide comprehensive and innovative consulting services to clients in the tourism industry. With a deep understanding of the local context and industry dynamics,
                                                </p>
                                        </div>
                               
                                        <center><div class="social-link">
                                            <a href="https://www.facebook.com/gatot.adiprana" target="_blank"><i
                                                    class='bx bxl-facebook'></i></a>
                                            <a href="https://twitter.com/gatotadiprana" target="_blank"><i
                                                    class='bx bxl-twitter'></i></a>
                                            <a href="https://www.instagram.com/gatotadiprana/" target="_blank"><i
                                                    class='bx bxl-instagram'></i></a>
                                        </div>
                                        </center>
                                        <br>
                                </div>
                            </div>
                                
                            </div>
                            <!-- Row -->
                        </div>
                        @endfor
                        <!-- column  -->
                        <!-- column  -->
                        
                        <!-- column  -->
                      </div>
                  </div>

            </div>
        </div>
    </section>
    <!-- end team section -->
@endsection()
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var paragraphs = document.querySelectorAll("p");

        paragraphs.forEach(function(paragraph) {
            var text = paragraph.textContent;
            var truncatedText = text.slice(0, 15);
            var isFullText = false;

            if (text.length > 15) {
                paragraph.textContent = truncatedText + "...";

                var readMoreLink = document.createElement("a");
                readMoreLink.textContent = "Read More";
                readMoreLink.setAttribute("href", "#");
                readMoreLink.style.color = "red"; // Set color to red

                readMoreLink.addEventListener("click", function(e) {
                    e.preventDefault();
                    if (isFullText) {
                        paragraph.textContent = truncatedText + "...";
                        readMoreLink.textContent = "Read More";
                        isFullText = false;
                    } else {
                        paragraphs.forEach(function(p) {
                            if (p !== paragraph) {
                                var pText = p.textContent;
                                if (pText.length > 15) {
                                    p.textContent = pText.slice(0, 15) + "...";
                                }
                            }
                        });
                        paragraph.textContent = text;
                        readMoreLink.textContent = "Hide";
                        readMoreLink.style.color = "red"; // Set color to red
                        isFullText = true;
                    }
                });

                paragraph.appendChild(readMoreLink);
            }
        });
    });
</script>
