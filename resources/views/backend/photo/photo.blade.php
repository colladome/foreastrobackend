@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Photos</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.storePhotos') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Category *</label>
                        <div class="col-sm-9">
                            <select class="form-select" aria-label="Select Category" name="category">
                                <option selected>Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category'))
                            <span class="text-danger">{{ $errors->first('category') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Name *</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="name" placeholder="Enter Name" value="" class="form-control" autocomplete="off" required>
                            @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Place *</label>
                        <div class="col-sm-9">
                            <input type="text" id="place" name="place" value="" placeholder="Enter Place" class="form-control" autocomplete="off" required>
                            @if($errors->has('place'))
                            <span class="text-danger">{{ $errors->first('place') }}</span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Cover Image *</label>
                        <div class="col-sm-9">
                            <input type="file" name="cover_image" class="form-control" required>
                            @if($errors->has('cover_image'))
                            <span class="text-danger">{{ $errors->first('cover_image') }}</span>
                            @endif
                        </div>
                    </div>



                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Gallery Photos *</label>
                        <div class="col-sm-9">
                            <input type="file" name="photos[]" class="form-control" multiple required>
                            @if($errors->has('photos'))
                            <span class="text-danger">{{ $errors->first('photos') }}</span>
                            @endif
                        </div>
                    </div>




                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
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