@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Add Blog</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <!-- <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Category</label>
                        <div class="col-sm-9">
                            <select class="form-select" aria-label="Default select example" name="category">
                                <option value="" selected>--Select Category--</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach

                            </select>

                            @if($errors->has('category'))
                            <span class="text-danger">{{ $errors->first('category') }}</span>
                            @endif
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Title</label>
                        <div class="col-sm-9">
                            <input type="text" id="title" placeholder="Title" name="title" class="form-control" autocomplete="off" required>
                            @if($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>




                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control summernote" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>

                            @if($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>

                    </div>



                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Slug</label>
                        <div class="col-sm-9">
                            <input type="text" id="slug" placeholder="Slug" name="slug" class="form-control" autocomplete="off">
                            @if($errors->has('slug'))
                            <span class="text-danger">{{ $errors->first('slug') }}</span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Meta Title</label>
                        <div class="col-sm-9">
                            <input type="text" id="meta_title" placeholder="Meta Title" name="meta_title" class="form-control" autocomplete="off" required>
                            @if($errors->has('meta_title'))
                            <span class="text-danger">{{ $errors->first('meta_title') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Meta Description</label>
                        <div class="col-sm-9">
                            <input type="text" id="meta_description" placeholder="Meta Description" name="meta_description" class="form-control" autocomplete="off" required>
                            @if($errors->has('meta_description'))
                            <span class="text-danger">{{ $errors->first('meta_description') }}</span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="banner">Image</label>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input class="form-control" type="file" name="image" id="image" onchange="validateFileSize(this)">

                            </div>
                            @if($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
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
<script>
    function validateFileSize(input) {
            const file = input.files[0];
            const maxSize = 2 * 1024 * 1024; // 2 MB in bytes
            if (file && file.size > maxSize) {
                alert("File size exceeds 2 MB. Please upload a smaller file.");
                input.value = ""; // Clear the input
            }
        }
</script>

@endsection