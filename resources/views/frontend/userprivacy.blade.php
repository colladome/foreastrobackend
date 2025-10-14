@extends('frontend.layouts.app')
<!--start contant section --->
@section('content')
<section class="">
    <div class="container text-white aos-init aos-animate" data-aos="fade-up">
        {!! $cms->user_privacy_policy !!}

    </div>
</section>

@endsection