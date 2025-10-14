@extends('frontend.layouts.app')
<!--start contant section --->
@section('content')
<section class="">
    <div class="container text-dark aos-init aos-animate" data-aos="fade-up">
        {!! $cms->privacy_policy !!}

    </div>
</section>

@endsection