@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Edit Celebrity</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.celebrity.celebrityUpdate', $celebrity->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Title</label>
                        <div class="col-sm-9">
                            <input type="text" id="title" name="title" value="{{ $celebrity->title }}" class="form-control" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="thumbnail">Thumbnail</label>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <label class="custom-file-label">
                                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="custom-file-input" onchange="validateFileSize(this)">
                                    <span class="custom-file-name">Choose file</span>
                                </label>
                                @if($errors->has('thumbnail'))
                                <span class="text-danger">{{ $errors->first('thumbnail') }}</span>
                                @endif
                            </div>
                        </div>
                        <span><img src="{{  asset('storage/' . $celebrity->thumbnail) }}" height="80 px;" width="100 px;"></span>

                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="video">Video</label>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <label class="custom-file-label">
                                    <input type="file" id="video" name="video" accept="video/*" class="custom-file-input">
                                    <span class="custom-file-name">Choose file</span>
                                </label>
                                @if($errors->has('video'))
                                <span class="text-danger">{{ $errors->first('video') }}</span>
                                @endif
                            </div>
                            <span><a href="{{  asset('storage/' . $celebrity->video_path) }}" target="_blank">Video Link</a></span>

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