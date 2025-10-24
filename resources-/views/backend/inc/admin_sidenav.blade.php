@php
$user = \Auth::user();
$permissions = !empty($user->permissions) ? $user->permissions : [];
@endphp





<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="{{-- route('admin.dashboard') --}}" class="d-block text-left">

                <img class="mw-100" src="{{ asset('assets/frontend/img/logo.png') }}" class="brand-icon" alt="">

            </a>
        </div>
        <div class="aiz-side-nav-wrap">


            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">

                Dashboard

                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Dashboard</span>
                    </a>
                </li>









                @if (Gate::check('User') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.listUser') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">User</span>
                    </a>
                </li>

                @endif


                @if (Gate::check('Astrologer') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.astrologers') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Astrologer</span>
                    </a>
                </li>
                @endif



              @if (Gate::check('Astrologer Report') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.astrologer.report') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Astrologer Report</span>
                    </a>
                </li>
                @endif


                @if (Gate::check('Blog Management') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.blog.index') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Blog Management</span>
                    </a>
                </li>
                @endif


                @if (Gate::check('CMS Management') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.cms.edit') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">CMS Management</span>
                    </a>
                </li>
                @endif


                @if (Gate::check('Query Management') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.contact.index') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Query Management</span>
                    </a>
                </li>
                @endif

                @if (Gate::check('Review Management') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.review.index') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Review Management</span>
                    </a>
                </li>
                @endif


                @if (Gate::check('Onboarding Question') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.question.index') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Onboarding Question</span>
                    </a>
                </li>
                @endif

                @if (Gate::check('Coupon') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.coupon.index') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Coupon</span>
                    </a>
                </li>
                @endif






                @if (Gate::check('Wallet Transaction') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.user.walletTransaction') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Wallet Transaction</span>
                    </a>
                </li>
                @endif


                @if (Gate::check('Celebrities') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.celebrity.celebrityList') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Celebrities</span>
                    </a>
                </li>
                @endif


                @if (Gate::check('Payment Management') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.paymentManagement') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Payment Management</span>
                    </a>
                </li>
                @endif


                @if (Gate::check('Payouts') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.payout') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Payouts</span>
                    </a>
                </li>
                @endif



                 @if (Gate::check('Testimonial') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.testimonial.index') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Testimonial</span>
                    </a>
                </li>
                @endif 
                
                @if (Gate::check('Call Logs') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ url('admin/call-logs') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Call Logs</span>
                    </a>
                </li>
                @endif 




                @if (Gate::check('MasterTable') || $user->user_type == 'admin')
                <!-- Master Table -->
                <li class="aiz-side-nav-item">
                    <a class="btn-toggle aiz-side-nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse">
                        <i class="las la-shopping-cart aiz-side-nav-icon"></i>
                        MasterTable
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <div class="collapse" id="dashboard-collapse">
                        <ul class="aiz-side-nav-list level-2">




                            @if (Gate::check('Banner Management') || $user->user_type == 'admin')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.masterTable.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">Banner Management</span>
                                </a>
                            </li>
                            @endif





                            @if (Gate::check('State') || $user->user_type == 'admin')
                            <!-- <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.masterTable.state.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">State</span>
                                </a> -->
                </li>
                @endif
                @if (Gate::check('City') || $user->user_type == 'admin')
                <!-- <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.masterTable.city.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">City</span>
                                </a>
                            </li> -->
                @endif


                @if (Gate::check('Staff Management') || $user->user_type == 'admin')

                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.staff.index') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Staff Management</span>
                    </a>
                </li>
                @endif
                @if (Gate::check('Roles') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.masterTable.role.index') }}" class="aiz-side-nav-link">

                        <span class="aiz-side-nav-text">Roles</span>
                    </a>
                </li>
                @endif

                @if (Gate::check('Permissions') || $user->user_type == 'admin')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.masterTable.permission.index') }}" class="aiz-side-nav-link">

                        <span class="aiz-side-nav-text">Permissions</span>
                    </a>
                </li>
                @endif









            </ul>
        </div>
        </li>
        {{-- @endcan --}}

        @endif






        </ul><!-- .aiz-side-nav -->
    </div><!-- .aiz-side-nav-wrap -->
</div><!-- .aiz-sidebar -->
<div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->