@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Add Edit</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.masterTable.role.update', $role->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">



                <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Role Name *</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="name" value="{{ $role->name }}" class="form-control" autocomplete="off" required>
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                        </div>
                </div>


            <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="purchase_code">Permission *</label>
                <div class="col-sm-9">

                    <select data-placeholder="-- Select Permission--" multiple class="form-select chosen-select" name="permissions[]">
                    
                    @foreach($permissions as $permission)
            
                        <option value="{{ $permission->name }}" {{ in_array($permission->name, $rolePermissions) ? 'selected': '' }}>{{ $permission->name }}</option>

                    @endforeach
                        
                    </select>

                    @if($errors->has('permissions'))
                     <span class="text-danger">{{ $errors->first('permissions') }}</span>
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
    $(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
})
    </script>

@endsection
