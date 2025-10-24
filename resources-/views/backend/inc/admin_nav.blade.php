@php
$user = \Auth::user();
$permissions = !empty($user->permissions) ? $user->permissions : [];
@endphp

<div class="aiz-topbar px-15px px-lg-25px d-flex align-items-stretch justify-content-between">
    <div class="d-flex">
        <div class="aiz-topbar-nav-toggler d-flex align-items-center justify-content-start mr-2 mr-md-3 ml-0" data-toggle="aiz-mobile-nav">
            <button class="aiz-mobile-toggler">
                <span></span>
            </button>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-stretch flex-grow-xl-1">
        <div class="d-flex justify-content-around align-items-center align-items-stretch">
            <div class="d-flex justify-content-around align-items-center align-items-stretch">
                <div class="aiz-topbar-item">
                    <div class="d-flex align-items-center">
                        <a class="btn btn-icon btn-circle btn-light" href="{{ route('index') }}" target="_blank" title="Browse Website">
                            <i class="las la-globe"></i>
                        </a>
                    </div>
                </div>
            </div>


        </div>
        <div class="d-flex justify-content-around align-items-center align-items-stretch">

            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon p-0 d-flex justify-content-center align-items-center">
                            <span class="d-flex align-items-center position-relative">
                                <i class="las la-bell fs-24"></i>
                                {{-- @if(Auth::user()->unreadNotifications->count() > 0) --}}
                                <span class="badge badge-sm badge-dot badge-circle badge-primary position-absolute absolute-top-right"></span>
                                {{-- @endif --}}
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg py-0">
                        <div class="p-3 bg-light border-bottom">
                            <h6 class="mb-0">Notifications</h6>
                        </div>
                        <div class="px-3 c-scrollbar-light overflow-auto " style="max-height:300px;">
                            <ul class="list-group list-group-flush">
                                {{-- @forelse(Auth::user()->unreadNotifications->take(20) as $notification) --}}
                                <li class="list-group-item d-flex justify-content-between align-items- py-3">
                                    <div class="media text-inherit">
                                        <div class="media-body">
                                            {{-- @if($notification->type == 'App\Notifications\OrderNotification') --}}
                                            <p class="mb-1 text-truncate-2">
                                                Order code: {{-- $notification->data['order_code'] --}} has been
                                            </p>
                                            <small class="text-muted">
                                                {{-- date("F j Y, g:i a", strtotime($notification->created_at)) --}}
                                            </small>
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                </li>
                                {{-- @empty --}}
                                <li class="list-group-item">
                                    <div class="py-4 text-center fs-16">
                                        No notification found
                                    </div>
                                </li>
                                {{-- @endforelse --}}
                            </ul>
                        </div>
                        <div class="text-center border-top">
                            <a href="{{-- route('admin.all-notification') --}}" class="text-reset d-block py-2">
                                View All Notifications
                            </a>
                        </div>
                    </div>
                </div>
            </div>



            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown " id="lang-change">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon">
                            <img src="{{-- asset('assets/img/flags/'.$locale.'.png') --}}" height="11">
                        </span>
                    </a>

                </div>
            </div>

            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow text-dark" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="d-flex align-items-center ">
                            <h6 class="m-0 mr-2">{{ $user->name }}</h6>
                            <span class="avatar avatar-sm mr-md-2">
                                <img src="{{-- uploaded_asset(Auth::user()->avatar_original) --}}" onerror="this.onerror=null;this.src='{{ asset('assets/img/avatar-place.png') }}';">
                            </span>
                            <span class="d-none d-md-block">
                                <span class="d-block fw-500">{{-- Auth::user()->name --}}</span>
                                <span class="d-block small opacity-60">{{-- Auth::user()->user_type --}}</span>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-md">

                        @if($user->user_type == 'admin')
                        <a href="{{ route('admin.profileEdit') }}" class="dropdown-item">
                            <i class="las la-user-circle"></i>
                            <span>Profile</span>
                        </a>

                        <a href="{{ route('admin.changePassword') }}" class="dropdown-item">
                            <i class="las la-user-circle"></i>
                            <span>Change Password</span>
                        </a>
                        @endif

                        <a href="{{ route('admin.logout') }}" class="dropdown-item">
                            <i class="las la-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div><!-- .aiz-topbar-item -->
        </div>
    </div>
</div><!-- .aiz-topbar -->