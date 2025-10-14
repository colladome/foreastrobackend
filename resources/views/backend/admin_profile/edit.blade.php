@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Change Profile</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.profileUpdate') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">



                <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Name *</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="name" placeholder="Enter Old Password" value="{{ $user->name }}" class="form-control" autocomplete="off" required>
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                        </div>
                </div>

                <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Email *</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="email" value="{{ $user->email }}" placeholder="Enter New Password" class="form-control" autocomplete="off" required>
                                    @if($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                        </div>
                </div>


                <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Phone Number *</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="mobile_number" value="{{ $user->mobile_number}}" placeholder="Enter New Password" class="form-control" autocomplete="off" required>
                                    @if($errors->has('mobile_number'))
                                        <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                                        @endif
                        </div>
                </div>


            

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
})
    </script>

@endsection
