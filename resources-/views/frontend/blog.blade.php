@extends('frontend.layouts.app')
<!--start contant section --->
@section('content')


<section class="blog-page d-flex align-items-end">
   <div class="container text-white aos-init aos-animate" data-aos="fade-up">
      <h2 class="head-font fw-bold text-white">Blog</h2>

      <p>
         Explore the cosmos through our insightful astrology blog
      </p>

   </div>
</section>

<section id="recent-posts" class="recent-posts">
   <div class="container" data-aos="fade-up">

      <div class="text-start mb-5 d-flex justify-content-between ">
         <h2 class="fw-bold text-capitalize ">All <span class="text-org">blog posts</span></h2>
      </div>

      <div class="row gy-4 my-3">

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
</section>
@endsection
<!-- end script section -->