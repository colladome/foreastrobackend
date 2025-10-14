@extends('backend.layouts.layout')

@section('content')

    <div class="py-6">
        <div class="container">
            <div class="row">
                <div class="col-xxl-5 col-xl-6 col-md-8 mx-auto">
                    @include('messages')
                    <div class="bg-white rounded shadow-sm p-4 text-left">
                        <h1 class="h3 fw-600">Forgot Password?</h1>
                        <p class="mb-4 opacity-60">Enter your email address to recover your password.
                        </p>
                        <form method="POST" action="{{ route('admin.forgetPassword') }}">
                            @csrf
                            <div class="form-group">

                              {{--  @if (addon_is_activated('otp_system')) --}}
                                    <!-- <div class="form-group phone-form-group mb-1">
                                        <input type="tel" id="phone-code"
                                            class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                            value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                    </div>

                                    <input type="hidden" name="country_code" value="">

                                    <div class="form-group email-form-group mb-1 d-none">
                                        <input type="email"
                                            class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            value="{{ old('email') }}" placeholder="Email"
                                            name="email" id="email" autocomplete="off">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group text-right">
                                        <button class="btn btn-link p-0 text-primary" type="button"
                                            ><i>*Use Email Instead</i></button>
                                    </div> -->
                               {{-- @else  --}}
                                    <div class="form-group">
                                        <input type="email"
                                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            value="{{ old('email') }}" placeholder="Email"
                                            name="email" id="email" autocomplete="off">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                               {{-- @endif  --}}
                     
                            </div>
                            <div class="form-group text-right">
                                <button class="btn btn-primary btn-block" type="submit">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </form>
                        <div class="mt-3">
                            <a href="{{ route('admin.index') }}"
                                class="text-reset opacity-60">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection



