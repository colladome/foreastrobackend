@extends('backend.layouts.layout')

@section('content')

<div class="h-100 bg-cover bg-center py-5 d-flex align-items-center" style="background-image: url({{-- uploaded_asset(get_setting('admin_login_background')) --}})">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-xl-4 mx-auto">
                <div class="card text-left">
                    <div class="card-body">
                        <div class="mb-5 text-center">

                            <img src="{{ asset('assets/img/skywedlogo.png') }}" class="mw-100 mb-4" height="96">
                            <!--- success and error messages --->
                            @include('messages')

                            <!--end success and error message --->

                            <h1 class="h3 text-primary mb-0">Vendor</h1>
                            <p>Login to your account.</p>
                        </div>
                        <form class="pad-hor" method="POST" role="form" action="{{ route('vendor.login') }}">
                            @csrf
                            <div class="form-group">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-sm-6">
                                <div class="text-right">
                                    <a href="{{ route('admin.forgetPasswordForm') }}" class="text-reset fs-14">Forgot password ?</a>
                                </div>
                            </div>

                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Login
                    </button>
                    </form>
                    <div class="mt-3">
                        <a href="{{ route('vendor.regester') }}" class="btn-link mar-rgt text-bold">Sign Up</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>


@endsection

@section('script')
<script type="text/javascript">
    function autoFill() {
        $('#email').val('admin@example.com');
        $('#password').val('123456');
    }
</script>
@endsection