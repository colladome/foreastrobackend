@extends('frontend.layouts.app')
@section('content')

<section class="contact-page d-flex align-items-end">
    <div class="container text-white aos-init aos-animate" data-aos="fade-up">
        <h2 class="head-font fw-bold text-white">Contact Us</h2>

        <p>
            reach out to us and let the stars guide our conversation
        </p>

    </div>
</section>

<section>
    <div class="container">
        <div class="row justify-content-between ">
            <div class="col-md-6">
                <div class="">
                    <h2 class="fw-semibold"><span class="text-org">Get in touch </span>with us</h2>
                    <p>we’ld love to hear from you! We’re here to help or answer<br> any questions</p>

                    <ul class="line-height list-unstyled text-start mt-4">
                        <li class="d-flex align-items-center gap-3 icon"><i class="fas fa-building text-org "></i>E-2216, Palam Vihar, Gurugram, Haryana-122017</li> 
                        <li class="d-flex align-items-center gap-3 icon"><i class="fas fa-phone fa-fw text-org "></i>+91
                            8100484950</li>
                        <li class="d-flex align-items-center gap-3 icon"><i class="fas fa-envelope text-org "></i>info@foreastro.com</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card border-0 px-4 shadow-box">
                    <div class="card-body">
                        @include('messages')
                        <form action="{{ route('contactUs') }}" method="post" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group my-2">
                                    <label for="" class="mb-2">Full Name</label>
                                    <input type="text" name="name" class="form-control shadow-none " id="name" placeholder="Your Name" required="">
                                </div>
                                <div class="col-md-6 form-group my-2">
                                    <label for="" class="mb-2">Email</label>
                                    <input type="email" class="form-control shadow-none " name="email" id="email" placeholder="Your Email" required="">
                                </div>
                            </div>
                            <div class="form-group my-2">
                                <label for="" class="mb-2">Phone No.</label>
                                <input type="text" class="form-control shadow-none " name="phone" id="phone" placeholder="Phone" required="">
                            </div>
                            <div class="form-group my-2">
                                <label for="" class="mb-2">What can we help you with?</label>
                                <textarea class="form-control   shadow-none " rows="7" name="descreption" placeholder="Message" required=""></textarea>
                            </div>
                            
                            <div class="g-recaptcha mt-4" data-sitekey={{config('services.recaptcha.key')}}></div>

                            <button type="submit" class="border-0 mt-3 text-center py-2 px-4 btn bg-org text-white">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection