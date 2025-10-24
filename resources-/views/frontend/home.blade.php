@extends('frontend.layouts.app')


@section('content')
<!-- ======= Hero Section ======= -->
<section id="hero" class="hero d-flex align-items-center position-relative ">
    <div class="container position-relative">
        <div class="row gy-5" data-aos="fade-in">
            <div class="col-lg-6 order-2 order-lg-1  d-flex flex-column justify-content-center text-center text-lg-start">
                <h2>Solution for Every <br>Aspect of life</h2>
                <p>Let our guidance shape your journey to a purposeful life</p>
                <div class="d-flex justify-content-center gap-3 justify-content-lg-start">
                    <!--<img src="{{ asset('assets/frontend/img/appstore.png') }}" alt="no" class="img-fluid">-->
                   <a href="https://play.google.com/store/apps/details?id=com.foreastro.foreastrouserside&amp;pcampaignid=web_share" target="_blank"> <img src="{{ asset('assets/frontend/img/playstroe.png') }}" alt="no" class="img-fluid">
                  </a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="{{ asset('assets/frontend/img/astrowheel.png') }}" class="img-fluid imgfix wheel" alt="" data-aos="zoom-out" data-aos-delay="100">
            </div>
        </div>
    </div>



    </div>
</section>
<!-- End Hero Section -->

<main id="main">
    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">

            <!-- <div class="section-header">
                    <h2>About Us</h2>
                    <p>Aperiam dolorum et et wuia molestias qui eveniet numquam nihil porro incidunt dolores placeat
                        sunt id nobis omnis tiledo stran delop</p>
                </div> -->

            <div class="gx-0 gx-md-5 gy-4 row">
                <div class="col-lg-4">
                    <img src="{{ asset('assets/frontend/img/aboutside.png') }}" class="img-fluid rounded-4 mb-4" alt="">

                </div>
                <div class="col-lg-7">
                    <div class="content">
                        <div class="text-start">
                            <p class="text-uppercase fw-medium ">Welcome to <span class="text-org">Foreastro</span>
                            </p>
                            <h2 class="head-font fw-bold ">Overview</h2>
                        </div>
                        <p class="lh-lg">
                            At ForeAstro, we're dedicated to making astrology accessible to all, empowering
                            individuals to navigate life's journey with clarity and purpose. Founded on authenticity
                            and compassion, our mission is to provide personalized astrological insights and
                            guidance that enrich lives and deepen connections to the universe.

                        </p>
                        <p class="lh-lg">With a commitment to integrity and accuracy, our team of expert astrologers
                            offers a
                            range of services, from personalized horoscopes to in-depth analyses, designed to
                            support you on your path to self-discovery and transformation. Join us as we explore the
                            mysteries of the cosmos together and unlock the infinite possibilities that lie within."
                        </p>



                    </div>
                </div>
            </div>

        </div>
    </section><!-- End About Us Section -->




    <!-- ======= Stats Counter Section ======= -->
        <section id="stats-counter" class="stats-counter">
        <div class="container" data-aos="fade-up">

            <div class="row gy-4 justify-content-center align-items-center">
                <div class="col-lg-12">
    
                    <div class="row gap-3 flex_class">
                        <div class="stats-item col-lg-3 col-md-5 d-flex align-items-center flex-column">
                            <div> <span class="text-org fw-bold d-flex gap-1"><span class="counter">46.1</span>Million</span>
                            </div>
                            <p><strong class="text-uppercase">Total Customers</strong></p>
                        </div>

                        <div class="stats-item col-lg-3 col-md-5 d-flex align-items-center flex-column   ">
                            <div> <span class="text-org fw-bold d-flex gap-1"><span class="counter">4.3</span>Rating</span>
                            </div>
                            <p><strong class="text-uppercase">In Google Play Store</strong></p>
                        </div>

                        <div class="stats-item col-lg-3 col-md-5 d-flex align-items-center flex-column ">
                            <div> <span class="text-org fw-bold d-flex gap-1"><span class="counter">721</span>Million Minutes</span>
                            </div>
                            <p><strong class="text-uppercase">Total Chat/Call Minutes</strong></p>
                        </div>

                        <div class="stats-item col-lg-3 col-md-5 d-flex align-items-center flex-column   ">
                            <div> <span class="text-org fw-bold d-flex gap-1"><span class="counter">23,254</span>+</span>
                            </div>
                            <p><strong class="text-uppercase">Total Astrologers</strong></p>
                        </div><!-- End Stats Item -->


                    </div><!-- End Stats Item -->

                </div>

            </div>

        </div>
    </section><!-- End Stats Counter Section -->

    <!-- ======= astrologers Section ======= -->
    <section class="astro position-relative ">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Connect with our <span class="text-org">Astrologers</span> Now</h2>
                <p class="text-center">Connect with our team of expert astrologers now for personalized guidance, clarity, and support.
                </p>
            </div>

            <div class="owl-carousel  owl-theme" id="connectwith">


                @foreach($listAstrologers as $listAstrologer)
                <div class="item">
                    <div class="card p-4 border-liner">
                        <div class="text-center">
                            <div class="img-border position-relative ">
                        
                                <img src="{{ $listAstrologer['profile_img']  }}" alt="no" class="img-fluid p-2 img-rounded rounded-circle">
                              
                                @if($listAstrologer['is_online'] == 'online')
                                <div class="online position-absolute"></div>
                                @else
                                <div class="online bg-danger position-absolute"></div>
                                @endif
                            </div>
                            <h4>{{ $listAstrologer['name'] }}</h4>
                            <p class="text-center">{{ $listAstrologer['specialization'] }}</p>


                        </div>
                        <span><i class="fa-solid fa-graduation-cap"></i> Exp: <b>{{ $listAstrologer['experience'] }} years</b></span>
                        <span><i class="fa-solid fa-language"></i> Language: <b>{{ implode(",", $listAstrologer['languaage'] ?? []) }}</b></span>
                        <div class="text-center"><a class="btn text-white mt-3 px-5 rounded-3  bg-org" href="#">Connect</a></div>

                    </div>
                </div>

                @endforeach



            </div>

        </div>
    </section>
    <!-- End astrologers Section -->

    <!-- cosmic wisdom start -->
    <section class="cosmic position-relative ">
        <div class="container" data-aos="fade-up">
            <div class="row g-md-5 ">
                <div class="col-md-7">
                    <div class="">
                        <h2 class="fw-semibold">Unlocking <span class="text-org">Cosmic Wisdom</span></h2>
                        <p>we offer a diverse range of products and solutions designed to help you harness the
                            wisdom of the stars and navigate life's journey with confidence. Our offerings include
                        </p>
                    </div>
                    <div class="d-flex gap-4  flex-md-row flex-column my-4">
                        <div class="d-flex flex-column gap-3 col-md-6">
                            <img src="{{ asset('assets/frontend/img/cosmic_icon1.svg') }}" alt="no" width="50" class="img-fluid image_center">
                            <h6>Personalized Horoscopes</h6>
                            <p>Get tailored daily, weekly, or monthly readings revealing insights into love, career,
                                and finances.</p>
                        </div>
                        <div class="d-flex flex-column gap-3 col-md-6">
                            <img src="{{ asset('assets/frontend/img/cosmic_icon2.svg') }}" alt="no" width="50" class="img-fluid image_center">
                            <h6>Chat with Astrologer</h6>
                            <p>Connect with expert astrologers for personalized guidance and clarity on life's
                                challenges.</p>
                        </div>

                    </div>
                    <div class="d-flex gap-4  flex-md-row flex-column my-4">
                        <div class="d-flex flex-column gap-3 col-md-6">
                            <img src="{{ asset('assets/frontend/img/cosmic_icon3.svg') }}" alt="no" width="50" class="img-fluid image_center">
                            <h6>Astrology Reports</h6>
                            <p>Explore in-depth reports uncovering your strengths, weaknesses, and life path
                                insights.</p>
                        </div>
                        <div class="d-flex flex-column gap-3 col-md-6">
                            <img src="{{ asset('assets/frontend/img/cosmic_icon4.svg') }}" alt="no" width="50" class="img-fluid image_center">
                            <h6>Astrology Blog</h6>
                            <p>Dive into our blog featuring articles, insights, and tips from our astrologers. Stay
                                informed and inspired with the latest astrological trends and forecasts.</p>
                        </div>

                    </div>
                    <a href="#" class="text-org fs-4 text-decoration-underline ">See all Features</a>
                </div>
                <div class="col-md-4 position-relative">
                    <div class="position-absolute top-0 start-0" style="transform: translate(-15%, -15%);">
                        <img src="{{ asset('assets/frontend/img/cosmicwheel.png') }}" alt="no" class="img-fluid wheel w-100">
                    </div>
                    <div class="position-relative shadow-img">
                        <img src="{{ asset('assets/frontend/img/cosmicimg.png') }}" alt="no" class="img-fluid w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- cosmic wisdom end-->


    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials position-relative ">
        <div class="position-absolute start-0 top-0">
            <img src="{{ asset('assets/frontend/img/sidehlf_circle.svg') }}" alt="no" class="img-fluid">
        </div>
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>What Our <span class="text-org">Users</span> Say</h2>
                <div class="row justify-content-center ">
                    <div class="col-md-6">
                        <p class="text-center">Discover what users are saying about their experiences with Foreastro. From
                            personalized horoscopes to astrological consultations, our users have found guidance,
                            clarity, and inspiration through our offerings.</p>
                    </div>
                </div>
            </div>

            <div class="slides-3 swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">




                    @foreach($testimonialList as $testimonial)

                    <div class="swiper-slide">
                        <div class="testimonial-wrap">
                            <div class="testimonial-item">
                                <div class="d-flex align-items-center gap-2 ">
                                    <img src="{{ $testimonial['imagee'] }}" class="testimonial-img flex-shrink-0" alt="">
                                    <div>
                                        <h3>{{ $testimonial['name'] }}</h3>

                                        <span class="stars ms-1">

                                            @if($testimonial['rating']=='1')
                                            <i class="bi bi-star-fill"></i>
                                            @elseif($testimonial['rating']=='2')


                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>

                                            @elseif($testimonial['rating']=='3')
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            @elseif($testimonial['rating']=='4')
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            @else

                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            @endif




                                        </span>
                                        </h4>
                                    </div>

                                </div>
                                <p>

                                    {{ $testimonial['comment'] }}

                                </p>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    @endforeach



















                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section>
    <!-- End Testimonials Section -->







    <!-- ======= Recent Blog Posts Section ======= -->
    <section id="recent-posts" class="recent-posts">
        <div class="container" data-aos="fade-up">

            <div class="text-start mb-5 d-flex justify-content-between ">
                <h2 class="fw-bold">Our <span class="text-org">Blogs</span></h2>
                <a href="{{ route('blog') }}" class="text-org fs-4 text-decoration-underline ">Read More</a>
            </div>

            <div class="row gy-4">

                @foreach($blogListing as $blog)
                <div class="col-xl-4 col-md-6">
                    <article class="p-0 rounded-0 ">

                        <div class="post-img m-0 rounded-0">
                            <img src="{{ $blog['image'] }}" alt="" class="img-fluid w-100 ">
                        </div>
                    </article>
                    <div class="container ps-0 py-3">
                        <p class="post-category">{{ $blog['date'] }}</p>

                        <h2 class="title d-flex justify-content-between  ">
                            <a href="{{ route('blogDetail', $blog['slug']) }}" class="text-dark">{{ $blog['title'] }}</a>
                            <i class="fas fa-arrow-up"></i>
                        </h2>

                        @php
                        $words = explode(' ', $blog['description']);
                        $excerpt = implode(' ', array_slice($words, 0, 30));
                        @endphp


                        @if (count($words) > 30)
                        <p> {!! $excerpt !!}... <a href="{{ route('blogDetail', $blog['slug']) }}">read more</a></p>
                        @else
                        <p>{!! $blog['description'] !!}</p>
                        @endif






                    </div>
                </div><!-- End post list item -->

                @endforeach

            </div><!-- End recent posts list -->

        </div>
    </section><!-- End Recent Blog Posts Section -->

   <section class="position-relative cta-section overflow-visible my-5 py-0">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-5 text-white order-md-0 order-1">
                    <h2 class="mr-top">Download App</h2>
                    <p>Ready to experience the power of astrology for yourself? Join foreastro today and embark on your cosmic journey!</p>
                    <div class="d-flex gap-3 justify-content-md-start justify-content-center order-md-1 order-0">
                        <!--<a href="#"> <img src="{{ asset('assets/frontend/img/appstore.png') }}" alt="no" class="img-fluid"></a>-->
                        <a href="https://play.google.com/store/apps/details?id=com.foreastro.foreastrouserside&pcampaignid=web_share" target="_blank">
                            <img src="{{ asset('assets/frontend/img/playstroe.png') }}" alt="no" class="img-fluid">
                        </a>

                    </div>
                </div>
                <div class="col-md-6 position-relative ">
                    <div class="bg_img"><img src="{{ asset('assets/frontend/img/appcircle1.svg') }}" alt="no" class="img-fluid"></div>
                    <div class="position-absolute top-0 shadow-img mob-img"><img src="{{ asset('assets/frontend/img/downloadapp.png') }}" alt="no" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->


@section('script')
<script>
    jQuery(document).ready(function($) {
        $('.counter').counterUp({
            delay: 20,
            time: 5000
        });
    });

    $(document).ready(function() {
        $('#connectwith').owlCarousel({
            loop: true,
            margin: 10,
            dots: true,
            nav: true,
            autoplay: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 4,
                    nav: true,
                    dots: true,
                    loop: true,
                    margin: 20
                }
            }
        })
    })
</script>

@endsection

@endsection