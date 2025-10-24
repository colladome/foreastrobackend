@extends('vendor.layouts.blank')

@section('content')


<div class="h-100 bg-cover bg-center py-5 d-flex align-items-center" style="background-image: url({{-- uploaded_asset(get_setting('admin_login_background')) --}})">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-xl-4 mx-auto">
                <div class="card text-left">
                    <div class="card-header">Create a New Vendor Account</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('vendor.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Name *</label>
                                <div class="col-sm-9">
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" autocomplete="off" required>
                                    @if($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Category *</label>
                                <div class="col-sm-9">

                                    <select data-placeholder="-- Select Category--" multiple class="form-select chosen-select" name="category[]">

                                        @foreach($categories as $category)

                                        @if(!empty(old('category')))


                                        <option value="{{ $category->id }}" {{ in_array($category->id ,  old('category') ) ? 'selected':'' }}>{{ $category->name }}</option>


                                        @else

                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif


                                        @endforeach

                                    </select>

                                    @if($errors->has('category'))
                                    <span class="text-danger">{{ $errors->first('category') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Email *</label>
                                <div class="col-sm-9">
                                    <input type="email" id="email" value="{{ old('email') }}" name="email" class="form-control" autocomplete="off" required>
                                    @if($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Contact Number *</label>
                                <div class="col-sm-9">
                                    <input type="text" id="mobile_number" value="{{ old('mobile_number') }}" name="mobile_number" class="form-control" autocomplete="off" required>
                                    @if($errors->has('mobile_number'))
                                    <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="purchase_code">Password *</label>
                                <div class="col-sm-9">
                                    <input type="password" id="password" name="password" class="form-control" autocomplete="off" required>
                                    @if($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="status" value="0">


                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                Register
                            </button>
                        </form>
                        <div class="mt-3">
                            Already have an account ? <a href="{{ route('vendor.index') }}" class="btn-link mar-rgt text-bold">Sign In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(".chosen-select").chosen({
        no_results_text: "Oops, nothing found!"
    })
</script>
@endsection