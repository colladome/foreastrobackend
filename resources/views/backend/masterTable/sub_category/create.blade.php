@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Add Sub Category</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.masterTable.subCategory.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">



                <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Category</label>
                        <div class="col-sm-9">
                        <select class="form-select" aria-label="Default select example" name="category">
                            <option selected>--Select Category--</option>
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
                        <label class="col-sm-3 col-from-label" for="purchase_code">Sub Category</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="name" class="form-control" autocomplete="off" required>
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
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

@endsection
