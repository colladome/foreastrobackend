@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Add Astrologer</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.astrologerr.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" id="name" name="name" class="form-control" autocomplete="off" required>
                                </div>
                                @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" id="email" name="email" class="form-control" autocomplete="off" required>
                                </div>
                                @if($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>


                    </div>


                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Phone</label>
                                <div class="col-sm-9">
                                    <input type="text" id="phone" name="mobile_number" class="form-control" autocomplete="off" required>
                                </div>
                                @if($errors->has('mobile_number'))
                                <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Gender</label>
                                <select class="col-sm-9 form-select" aria-label="Default select example" name="gender">
                                    <option selected>--Select Gender--</option>

                                    <option value="male">Male</option>
                                    <option value="female">Female</option>


                                </select>

                                @if($errors->has('gender'))
                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                                @endif
                            </div>
                        </div>


                    </div>



                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection