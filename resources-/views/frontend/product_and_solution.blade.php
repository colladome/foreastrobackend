@extends('frontend.layouts.app')
<!--start contant section --->
@section('content')

<section class="service-page d-flex align-items-end">
    <div class="container text-white aos-init aos-animate" data-aos="fade-up">
        <h2 class="head-font fw-bold text-white">Products & Solutions</h2>

        <p>
            Discover Your Path with Our Astrological Services
        </p>

    </div>
</section>

<section class="service">
    <div class="container">
        <div class="row">
            <div class="text-start mb-5 d-flex justify-content-center">
                <h2 class="fw-bold  text-capitalize">Services <span class="text-org"> We Provide</span></h2>
            </div>
            <div class="col-md-3">
                <div class="card b-h-box font-14 border-0 mb-4">
                    <img class="card-img" src="{{ asset('assets/frontend/img/service1.png') }}" alt="Card image">
                    <div class="card-img-overlay overflow-hidden text-start">

                        <h5 class="card-title fw-semibold lh-base ">
                            Personalized <br> Horoscopes
                        </h5>
                        <p class="text">Offer one-on-one consultations with experienced astrologers for personalized
                            insights and guidance on life decisions, relationships, career, and more.</p>
                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="card b-h-box font-14 border-0 mb-4">
                    <img class="card-img" src="{{ asset('assets/frontend/img/service1.png') }}" alt="Card image">
                    <div class="card-img-overlay overflow-hidden text-start">

                        <h5 class="card-title fw-semibold lh-base ">
                            Astrological <br> Consultations
                        </h5>
                        <p class="text">Offer one-on-one consultations with experienced astrologers for personalized
                            insights and guidance on life decisions, relationships, career, and more.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card b-h-box font-14 border-0 mb-4">
                    <img class="card-img" src="{{ asset('assets/frontend/img/service2.png') }}" alt="Card image">
                    <div class="card-img-overlay overflow-hidden text-start">

                        <h5 class="card-title fw-semibold lh-base ">
                            Astrology <br> Reports
                        </h5>
                        <p class="text">Offer one-on-one consultations with experienced astrologers for personalized
                            insights and guidance on life decisions, relationships, career, and more.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card b-h-box font-14 border-0 mb-4">
                    <img class="card-img" src="{{ asset('assets/frontend/img/service3.png') }}" alt="Card image">
                    <div class="card-img-overlay overflow-hidden text-start">

                        <h5 class="card-title fw-semibold lh-base ">
                            Compatibility <br> Analysis
                        </h5>
                        <p class="text">Offer one-on-one consultations with experienced astrologers for personalized
                            insights and guidance on life decisions, relationships, career, and more.</p>
                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="card b-h-box font-14 border-0 mb-4">
                    <img class="card-img" src="{{ asset('assets/frontend/img/service4.png') }}" alt="Card image">
                    <div class="card-img-overlay overflow-hidden text-start">

                        <h5 class="card-title fw-semibold lh-base ">
                            Planetary <br> Alignments
                        </h5>
                        <p class="text">Offer one-on-one consultations with experienced astrologers for personalized
                            insights and guidance on life decisions, relationships, career, and more.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card b-h-box font-14 border-0 mb-4">
                    <img class="card-img" src="{{ asset('assets/frontend/img/service5.png') }}" alt="Card image">
                    <div class="card-img-overlay overflow-hidden text-start">

                        <h5 class="card-title fw-semibold lh-base ">
                            Dream <br> Interpretation
                        </h5>
                        <p class="text">Offer one-on-one consultations with experienced astrologers for personalized
                            insights and guidance on life decisions, relationships, career, and more.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card b-h-box font-14 border-0 mb-4">
                    <img class="card-img" src="{{ asset('assets/frontend/img/service6.png') }}" alt="Card image">
                    <div class="card-img-overlay overflow-hidden text-start">

                        <h5 class="card-title fw-semibold lh-base ">
                            Astrology <br> Blog
                        </h5>
                        <p class="text">Offer one-on-one consultations with experienced astrologers for personalized
                            insights and guidance on life decisions, relationships, career, and more.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card b-h-box font-14 border-0 mb-4">
                    <img class="card-img" src="{{ asset('assets/frontend/img/service7.png') }}" alt="Card image">
                    <div class="card-img-overlay overflow-hidden text-start">

                        <h5 class="card-title fw-semibold lh-base ">
                            Live <br> Sessions
                        </h5>
                        <p class="text">Offer one-on-one consultations with experienced astrologers for personalized
                            insights and guidance on life decisions, relationships, career, and more.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
@endsection