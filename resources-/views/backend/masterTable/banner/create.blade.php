@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Add Banner</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.masterTable.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Link</label>
                        <div class="col-sm-9">
                            <input type="text" id="link" name="link" class="form-control" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="banner">Banner</label>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <label class="custom-file-label">
                                    <input type="file" id="banner" name="banner" class="custom-file-input" required>
                                    <span class="custom-file-name">Choose file</span>
                                </label>
                                @if($errors->has('banner'))
                                <span class="text-danger">{{ $errors->first('banner') }}</span>
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