@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Edit Category</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.masterTable.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Category</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="name" value="{{ $category->name }}" class="form-control" autocomplete="off" required>
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Listing Order</label>
                        <div class="col-sm-9">
                            <input type="text" id="order" name="order" value="{{ $category->order }}" class="form-control" autocomplete="off" required>
                                    @if($errors->has('order'))
                                        <span class="text-danger">{{ $errors->first('order') }}</span>
                                        @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Description</label>
                        <div class="col-sm-9">
                          <textarea class="form-control"  id="exampleFormControlTextarea1" rows="3" name="description">{{ $category->description }}</textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="banner">Image</label>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input class="form-control" type="file" name="image" id="image">
                                
                            </div>
                            <span>{{ $category->image['file'] }}</span>
                            @if($errors->has('image'))
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
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

@endsection
