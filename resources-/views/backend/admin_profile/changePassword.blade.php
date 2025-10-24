@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Change Password</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.changePasswordSave') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">



                <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Old Password *</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="old_password" placeholder="Enter Old Password" value="" class="form-control" autocomplete="off" required>
                                    @if($errors->has('old_password'))
                                        <span class="text-danger">{{ $errors->first('old_password') }}</span>
                                    @endif
                        </div>
                </div>

                <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">New Password *</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="new_password" value="" placeholder="Enter New Password" class="form-control" autocomplete="off" required>
                                    @if($errors->has('new_password'))
                                        <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                        @endif
                        </div>
                </div>


            

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">Change Password</button>
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
