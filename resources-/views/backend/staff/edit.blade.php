@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Edit Staff</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">



                <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Name *</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="name" value="{{ $staff->name }}" class="form-control" autocomplete="off" required>
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                        </div>
                    </div>


            <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="purchase_code">Role *</label>
                <div class="col-sm-9">

                    <select class="form-select" name="role">
                    
                   

                    @foreach($staff->roles as $staffRole)
                    @foreach($roles as $role)
            
                        <option value="{{ $role->id }}" {{ $role->id === $staffRole->id  ? 'selected':'' }}>{{ $role->name }}</option>

                    @endforeach
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
                            <input type="email" id="email" name="email" value="{{ $staff->email }}" class="form-control" autocomplete="off" required>
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                        </div>
                    </div>



                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Contact Number *</label>
                        <div class="col-sm-9">
                            <input type="text" id="mobile_number" name="mobile_number" value="{{ $staff->mobile_number }}" class="form-control" autocomplete="off" required>
                                    @if($errors->has('mobile_number'))
                                        <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                                        @endif
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Password</label>
                        <div class="col-sm-9">
                            <input type="text" id="mobile_number" name="password" placeholder="Password" value="" class="form-control" autocomplete="off" required>
                                    @if($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                        </div>
                    </div>

              
                <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Status *</label>
                    <div class="col-sm-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="1" id="flexRadioDefault1" {{ $staff->status == '1' ? 'checked':'' }}>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Active
                            </label>
                       </div>                                    
                    </div>


                <div class="col-sm-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="0" id="flexRadioDefault2" {{ $staff->status == '0' ? 'checked':'' }}>
                        <label class="form-check-label" for="flexRadioDefault2">
                        Inactive
                        </label>
                    </div>                                   
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
    $(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
})
    </script>

@endsection
