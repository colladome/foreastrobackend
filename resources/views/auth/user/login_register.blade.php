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
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" onclick="changeImage('{{ asset('assets/frontend/assets/img/login/signup-img2.png') }}')">Login</a>
                        </li>
                        <!-- <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#menu1"
                                    onclick="changeImage('./assets/img/login/signup-img3.png')">Gust Login</a>
                            </li> -->
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#menu2" onclick="changeImage('{{ asset('assets/frontend/assets/img/login/signup-img.png') }}')">Sign Up</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="menu2" class="container tab-pane "><br>
                            <form method="POST" action="{{ route('user.store') }}" id="signup">
                                @csrf
                                <div class="form-row">
                                    <div class="col">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control mb-0" required placeholder="Name">
                                    </div>
                                    <div class="col">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control mb-0" required placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label>Mobile Number</label>
                                        <input type="text" name="mobile_number" maxlength="10" onkeypress="return /[0-9]/i.test(event.key)" class="form-control mb-0" required placeholder="Mobile Number">
                                    </div>

                                </div>
                                <!-- <div class="form-row">
                                        <div class="col-md-12">
                                            <label>Address</label>
                                            <textarea class="form-control mb-3" rows="2"
                                                placeholder="Type your address"></textarea>
                                        </div>
                                    </div> -->
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="font-sm">
                                            <input type="checkbox" class="form-check-input" value=""><span class="ml-4">By
                                                signing up, you agree to our <a href="#" class="text-pink">team</a> of
                                                use and <a href="#" class="text-pink">privacy policy</a></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <button type="submit" class="btn login-submit-btn mx-auto py-3">SUBMIT &nbsp;<i class="fas fa-long-arrow-alt-right"></i> </button>
                                </div>
                            </form>
                        </div>
                        <div id="menu1" class="container tab-pane fade "><br>
                            <form>
                                <div class="form-row">
                                    <div class="col-12">
                                        <label>Login Id</label>
                                        <input type="email" class="form-control" required placeholder="admin@skyweds.com">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12">
                                        <label>Password</label>
                                        <input type="password" class="form-control" required placeholder="***********">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label>No of people</label>
                                        <div class="custom-select">
                                            <select>
                                                <option value="0">43</option>
                                                <option value="1">42</option>
                                                <option value="2">34</option>
                                                <option value="3">73</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label>Relations</label>
                                        <input type="text" class="form-control" required placeholder="xyz">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <button class="btn login-submit-btn  mx-auto py-3">SUBMIT &nbsp;<i class="fas fa-long-arrow-alt-right"></i> </button>
                                </div>
                            </form>
                        </div>
                        <div id="home" class="container tab-pane  active"><br>
                            <form action="{{ route('otp') }}" method="POST"id="login">
                                @csrf
                                <div class="form-row">
                                    <div class="col-12">
                                        <label>Mobile Number<em class="text-danger">*</em></label>
                                        <input type="text" class="form-control mb-0" maxlength="10" name="mobile"onkeypress="return /[0-9]/i.test(event.key)" required placeholder="123 546 6789">
                                    </div>
                                </div>
                                <!-- <div class="form-row">
                                    <div class="col-12">
                                        <label>OTP</label>
                                        <input type="text" class="form-control" placeholder="34 67 90">
                                    </div>
                                </div> -->
                                <div class="form-row">
                                    <button type="submit" class="btn login-submit-btn mx-auto py-3">SUBMIT &nbsp;<i class="fas fa-long-arrow-alt-right"></i> </button>
                                </div>
                            </form>
                            <div class="change-mobile"><a href="#">Change Mobile Number</a></div>
                            <div class="login-with-social d-flex">
                                <ul>
                                    <li><a href="#"><img src="{{ asset('assets/frontend/assets/img/icon/fb-icon.png') }}" alt="Image" class="img-responsive center-block"></a></li>
                                    <li><a href="{{ route('loginWithGoogle') }}"><img src="{{ asset('assets/frontend/assets/img/icon/google-icon.png') }}" alt="Image" class="img-responsive center-block"></a></li>
                                    <li><a href="#"><img src="{{ asset('assets/frontend/assets/img/icon/fb-icon.png') }}" alt="Image" class="img-responsive center-block"></a></li>
                                </ul>
                            </div>
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
    $("#login").validate({
        rules: {  
      mobile:{
        minlength: 10,
        maxlength: 10,
      }
     
    },  
    messages: { 
     mobile:{
        required:"Enter Your Mobile Number",
        maxlength:"MaxLength is 10 number",
        minlength:"MinLength is 10 number",
     }
    },
       
    });
    $("#signup").validate({
        rules: {  
            name:{
        required:true,
      },
        mobile_number:{
        minlength: 10,
        maxlength: 10,
      },
     
      email:{
        required: true,
        email:true,
      }
    },  
    messages: { 
        name:{
          required:"Enter Your Name",
      },
        mobile_number:{
            required:"Enter Your Mobile Number",
        maxlength:"MaxLength is 10 number",
        minlength:"MinLength is 10 number",
     },
    
     email:{
        required:"Enter Your Email",
        email:"Enter valid email",
     }
    },
       
    });
</script>
@endsection
@endsection