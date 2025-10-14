@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Add Testimonial</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.testimonial.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Name</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="name" class="form-control" autocomplete="off" required>
                        </div>
                    </div>



                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="image">Image</label>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <label class="custom-file-label">
                                    <input type="file" id="image" name="image" accept="image/*" class="custom-file-input" required>
                                    <span class="custom-file-name">Choose file</span>
                                </label>
                                @if($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Review</label>
                        <div class="col-sm-9">
                            <input type="text" id="review" onkeypress="return /[0-9]/i.test(event.key)" name="review" class="form-control" autocomplete="off" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="descreption">Discretion</label>
                        <div class="col-sm-9">
                            <div class="form-group">

                                <textarea class="form-control" id="descreption" name="descreption" rows="3" required></textarea>
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