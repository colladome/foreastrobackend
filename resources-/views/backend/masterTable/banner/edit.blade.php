@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Update Banner</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.masterTable.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Link</label>
                        <div class="col-sm-9">
                            <input type="text" id="link" name="link" value="{{ $banner->link }}" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="banner">Banner</label>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <label class="custom-file-label">
                                    <input type="file" id="banner" name="banner" class="custom-file-input" required>
                                </label>
                            </div>
                            <span class="custom-file-name"><img src="{{  asset('storage/' . $banner->name['file']) }}" height="80 px;" width=" px;"></span>

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

@endsection