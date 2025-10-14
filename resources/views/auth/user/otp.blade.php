@extends('frontend.layouts.app')
<!--start contant section --->
@section('content')
<!-- -------------------vendor-category ------------------- -->
<div class="container weds-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sign Up</li>
        </ol>
    </nav>
</div>
<!-- ---------------sign-up------------------- -->
<section class="sign-up-section">
    <div class="container">
        <h3>India’s Favourite Wedding Planning Platform</h3>
        <div class="row signup-div">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="signup-div-img">
                    <img src="{{ asset('assets/frontend/assets/img/login/signup-img.png') }}" id="form_img">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="signup-div-form">

                    @include('messages')

                    <!-- Nav tabs -->



                </div>

                <div id="home" class="container"><br>
                    <form action="{{ route('verifyOtp')}}" method="POST"id="otp">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="form-row">
                            <div class="col-12">
                                <label>OTP</label>
                                <input type="text" name="otp" maxLength="6" onkeypress="return /[0-9]/i.test(event.key)" required class="form-control" placeholder="34 67 90">
                            </div>
                        </div>
                        <div class="form-row">
                            <button type="submit" class="btn login-submit-btn  text-white mx-auto">Verify OTP &nbsp;<i class="fas fa-long-arrow-alt-right"></i> </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
<!-- --------------end-sign-up------------------- -->
<!-- ------------------expert section---------------- -->
<section class="expert-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="{{ asset('assets/frontend/assets/img/icon/expert.png') }}" class="img-responsive">
                <div class="title">Contact a Wedding Expert for Free</div>
                <div class="subtitle">
                    <p>We'd love to assist you! 7 days a week from 9am to 8pm</p>
                </div>
                <div class="whatsapp-box">
                    <a href="#"><img src="{{ asset('assets/frontend/assets/img/icon/whatsapp.png') }}" class="img-responsive"><span>Call
                            991-050-2284</span></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- --------------------------end expert section --------------------------- -->
@section('script')

<script>
    $("#otp").validate({
        rules: {  
      otp: {  
        required: true,  
      },  
    
    },  
    messages: { 
        otp:{
            required:"Please fill your OTP",
        },
    },
       
    });
</script>
@endsection
@endsection