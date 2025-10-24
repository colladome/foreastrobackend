@extends('frontend.layouts.app')
<!--start contant section --->
@section('content')
<section class="about-page d-flex align-items-end">
    <div class="container text-white aos-init aos-animate" data-aos="fade-up">
        <h2 class="head-font fw-bold text-white">About Us</h2>

        <p>
            Exploring the cosmos together. Join us
        </p>

    </div>
</section>
<section class="position-relative ">
    <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2>Company <span class="text-org fw-semibold ">History</span> </h2>
            <div class="row justify-content-center ">
                <div class="col-md-8">
                    <p class="text-center">At ForeAstro, we're dedicated to making astrology accessible to all, empowering individuals to
                        navigate
                        life's journey with clarity and purpose. Founded on authenticity and compassion, our mission is
                        to
                        provide personalized astrological insights and guidance that enrich lives and deepen connections
                        to the
                        universe.

                    </p>
                    <p class="text-center"> With a commitment to integrity and accuracy, our team of expert astrologers offers a range of
                        services,
                        from personalized horoscopes to in-depth analyses, designed to support you on your path to
                        self-discovery and transformation. Join us as we explore the mysteries of the cosmos together
                        and unlock
                        the infinite possibilities that lie within."</p>
                </div>
            </div>
            <div class="row position-relative g-3   align-items-end  my-5">
                <div class="col-md-6">
                    <div class="card traslate border-0  text-start shadow">
                        <div class="card-body p-4">
                            <h6 class="text-org fw-semibold ">Growth</h6>
                            <p>At Foreastro, our mission is to empower individuals through astrology by providing
                                personalized insights, fostering self-awareness, and facilitating meaningful connections
                                with the cosmos. We strive to make astrology accessible, relatable, and transformative
                                for all, guiding our community towards clarity, purpose, and fulfillment on their cosmic
                                journey.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('assets/frontend/img/growth.png') }}" alt="no" class="img-fluid w-100">
                </div>
            </div>
            <div class="row position-relative g-3   flex-row-reverse   align-items-end my-5 py-5">
                <div class="col-md-6">
                    <div class="card  border-0 z-3  traslatey text-start shadow">
                        <div class="card-body p-4">
                            <h6 class="text-org fw-semibold ">Mission</h6>
                            <p>At Foreastro, our mission is to revolutionize the way individuals engage with
                                astrology. We strive to empower our community by providing personalized astrological
                                insights and guidance, fostering self-awareness, clarity, and fulfillment on their
                                unique cosmic journey. Our commitment lies in making astrology accessible, relatable,
                                and transformative for all.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 traslatex">
                    <img src="{{ asset('assets/frontend/img/mission.png') }}" alt="no" class="img-fluid w-100">
                </div>
            </div>
            <div class="row position-relative g-3   align-items-end  my-5">
                <div class="col-md-6">
                    <div class="card traslate border-0  text-start shadow">
                        <div class="card-body p-4">
                            <h6 class="text-org fw-semibold ">Values</h6>
                            <p>At Foreastro, our foundation rests upon a set of core values that guide our every
                                endeavor. We are committed to authenticity, ensuring that every astrological insight we
                                provide is genuine and resonates with our users. Our mission is to empower individuals,
                                offering them the tools and guidance they need to make informed decisions, navigate
                                challenges, and embrace opportunities with confidence.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('assets/frontend/img/values.png') }}" alt="no" class="img-fluid w-100">
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