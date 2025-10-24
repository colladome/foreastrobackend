@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Add Area</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.masterTable.area.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">



                <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">State</label>
                        <div class="col-sm-9">
                        <select class="form-select" id="state" aria-label="Default select example" name="state">
                            <option selected>--Select State--</option>
                            @foreach($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                            
                        </select>

                                       @if($errors->has('state'))
                                        <span class="text-danger">{{ $errors->first('state') }}</span>
                                        @endif
                        </div>
                    </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="purchase_code">City</label>
                    <div class="col-sm-9">
                        <select class="form-select" id="city" aria-label="Default select example" name="city">
                            <option selected>--Select City--</option>
                           
                            
                        </select>

                        @if($errors->has('city'))
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                        @endif
                        </div>
                    </div>
                



                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Area</label>
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

<script>

 //  filter city

 $(document).on('change', '#state', function() {
        let state_id = $(this).val();
        // alert(status);
        $.ajax({
            type: "GET",
            url: "{{ route('filterCity') }}",
            data: {
                'state_id': state_id
            },
            success: function(data) {
                console.log(data);
                $("#city").html(data);
            }
        });

    });

</script>

@endsection
