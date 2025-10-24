@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5>CMS Management</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.cms.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body">
                            <h5 class="mb-0 h6">Contact us</h5>
                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Phone</label>
                                <div class="col-sm-9">
                                    <input type="text" id="phone" placeholder="Phone" value="{{ $cmsManagement->phone }}" name="phone" class="form-control" autocomplete="off" required>
                                    @if($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" value="{{ $cmsManagement->email }}" id="email" placeholder="Email" name="email" class="form-control" autocomplete="off" required>
                                    @if($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Address</label>
                                <div class="col-sm-9">
                                    <input type="text" id="address" value="{{ $cmsManagement->address }}" placeholder="Address" name="address" class="form-control" autocomplete="off">
                                    @if($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>


                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body">
                            <h5 class="mb-0 h6">Privacy Policy</h5>









                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Astrologer Privacy Policy</label>
                                <div class="col-sm-9">



                                    <textarea class="aiz-text-editor form-control summernote" placeholder="Content.." name="privacy_policy" required>{!! $cmsManagement->privacy_policy !!}</textarea>
                                    @if($errors->has('privacy_policy'))
                                    <span class="text-danger">{{ $errors->first('privacy_policy') }}</span>
                                    @endif
                                </div>

                            </div>




                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">User Privacy Policy</label>
                                <div class="col-sm-9">



                                    <textarea class="aiz-text-editor form-control summernote" placeholder="Content.." name="user_privacy_policy" required>{!! $cmsManagement->user_privacy_policy !!}</textarea>
                                    @if($errors->has('privacy_policy'))
                                    <span class="text-danger">{{ $errors->first('privacy_policy') }}</span>
                                    @endif
                                </div>

                            </div>






                        </div>
                    </div>
                </div>
                <div class="vr"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body">

                            <h5 class="mb-0 h6">Terms</h5>




                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Terms</label>
                                <div class="col-sm-9">



                                    <textarea class="aiz-text-editor form-control summernote" placeholder="Content.." name="terms" required>{!! $cmsManagement->terms !!}</textarea>



                                    @if($errors->has('terms'))
                                    <span class="text-danger">{{ $errors->first('terms') }}</span>
                                    @endif
                                </div>

                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Astrologer Live Charges Per Minute</label>
                                <div class="col-sm-9">
                                    <input type="text" id="astrologer_live_charges_per_min" placeholder="Astrologer Live Charges Per Minute" value="{{ $cmsManagement->astrologer_live_charges_per_min }}" name="astrologer_live_charges_per_min" class="form-control" autocomplete="off" required>
                                    @if($errors->has('astrologer_live_charges_per_min'))
                                    <span class="text-danger">{{ $errors->first('astrologer_live_charges_per_min') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Astrologer Boost Charges</label>
                                <div class="col-sm-9">
                                    <input type="text" id="boost_charges" placeholder="Astrologer Boost Charges" value="{{ $cmsManagement->boost_charges }}" name="boost_charges" class="form-control" autocomplete="off" required>
                                    @if($errors->has('boost_charges'))
                                    <span class="text-danger">{{ $errors->first('boost_charges') }}</span>
                                    @endif
                                </div>
                            </div>




                            <div class="form-group mb-0 text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection