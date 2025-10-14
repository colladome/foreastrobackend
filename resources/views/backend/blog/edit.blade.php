@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Add Blog</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <!-- <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Category</label>
                        <div class="col-sm-9">
                            <select class="form-select" aria-label="Default select example" name="category">
                                <option selected>--Select Category--</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $blog->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                            <input type="text" id="title" placeholder="Title" value="{{ $blog->title }}" name="title" class="form-control" autocomplete="off" required>
                            @if($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>




                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control summernote" id="exampleFormControlTextarea1" rows="3" name="description">{!! $blog->description !!}</textarea>
                            @if($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>

                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Slug</label>
                        <div class="col-sm-9">
                            <input type="text" id="slug" placeholder="Slug" name="slug" value="{{ $blog->slug }}" class="form-control" autocomplete="off">
                            @if($errors->has('slug'))
                            <span class="text-danger">{{ $errors->first('slug') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Meta Title</label>
                        <div class="col-sm-9">
                            <input type="text" id="meta_title" placeholder="Meta Title" name="meta_title" value="{{ $blog->meta_title }}" class="form-control" autocomplete="off" required>
                            @if($errors->has('meta_title'))
                            <span class="text-danger">{{ $errors->first('meta_title') }}</span>
                            @endif
                        </div>
                    </div>




                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Meta Description</label>
                        <div class="col-sm-9">
                            <input type="text" id="meta_description" placeholder="Meta Description" name="meta_description" value="{{ $blog->meta_description }}" class="form-control" autocomplete="off" required>
                            @if($errors->has('meta_description'))
                            <span class="text-danger">{{ $errors->first('meta_description') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="banner">Imagee</label>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input class="form-control" type="file" name="image" id="image" onchange="validateFileSize(this)">

                            </div>

                            @if(isset($blog->image['file']))
                            <span class="text-danger"><img src="{{ asset('storage/' . $blog->image['file']) }}" width="150px;" height="150px;"></span>
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