 <!-- ======= Header ======= -->
 <section id="topbar" class="topbar d-flex align-items-center">
   <div class="container d-flex justify-content-center justify-content-md-end">
     <div class="contact-info d-flex align-items-center">
       <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:info@foreastro.com">info@foreastro.com</a></i>
       <i class="bi bi-phone d-flex align-items-center ms-4"><a href="tel:+91-8100484950"><span>+91 8100484950</span></a></i>
     </div>

   </div>
 </section><!-- End Top Bar -->

 <header id="header" class="header d-flex align-items-center">

   <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
     <a href="{{ route('index') }}" class="logo d-flex align-items-center">
       <!-- Uncomment the line below if you also wish to use an image logo -->
       <img src="{{ asset('assets/frontend/img/logo.png') }}" alt="">
       <!-- <h1>Impact<span>.</span></h1> -->
     </a>
     <nav id="navbar" class="navbar">
       <ul>
         <li><a href="{{ route('index') }}">Home</a></li>
         <li><a href="{{ route('aboutUs') }}">About</a></li>
         <li><a href="{{ route('productAndSolution') }}">Our Services</a></li>
         <li><a href="{{ route('blog') }}">Blog</a></li>
         <!-- <li><a href="#portfolio">Partner With Us</a></li> -->

         <li><a href="{{ route('contactPage') }}">Contact</a></li>
       </ul>
     </nav><!-- .navbar -->

     <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
     <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

   </div>
 </header><!-- End Header -->
 <!-- End Header -->