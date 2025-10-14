@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Add New Booking</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.productBookingSave') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Users *</label>
                        <div class="col-sm-9">
                            <select class="form-select" aria-label="Select Users" name="user_id" required>
                                <option selected>Select Users</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user_id'))
                            <span class="text-danger">{{ $errors->first('user_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">vendors *</label>
                        <div class="col-sm-9">
                            <select class="form-select" aria-label="Select vendors" id="vendor" name="vendor_id">
                                <option selected>Select vendors</option>
                                @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('vendor_id'))
                            <span class="text-danger">{{ $errors->first('vendor_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-3 col-from-label" for="purchase_code">Select Product *</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="product" aria-label="Default select example" name="category_id">
                                <option selected>--Select Product--</option>


                            </select>

                            @if($errors->has('business_profile_id'))
                            <span class="text-danger">{{ $errors->first('business_profile_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Select a Date *</label>
                        <div class="col-sm-9">
                            <label for="datepicker" class="fw-bold"></label>
                            <input type="text" id="datepicker" name="booking_date[]" required placeholder="Select a Date" class="form-control">
                        </div>
                        @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="form-group row" id="room">
                        <label class="col-sm-3 col-from-label" for="purchase_code">No of rooms *</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control border" maxlength="3" id="room" conkeypress="return /[0-9]/i.test(event.key)" required name="number_of_room" placeholder="No of rooms">
                        </div>
                        @if($errors->has('number_of_room'))
                        <span class="text-danger">{{ $errors->first('number_of_room') }}</span>
                        @endif
                    </div>
                    <div class="form-group row" id="guest">
                        <label class="col-sm-3 col-from-label" for="purchase_code">No of guest *</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control border" maxlength="4" onkeypress="return /[0-9]/i.test(event.key)" required name="number_of_guest" placeholder="No of guests*">

                        </div>
                        @if($errors->has('number_of_guest'))
                        <span class="text-danger">{{ $errors->first('number_of_guest') }}</span>
                        @endif
                    </div>



                    <div class="row">
                        <div class="col-12 radio-lebel">Function Type</div>
                        <div class="col-12">
                            <div class="form-check-inline">
                                <input class="form-check-input" required name="function_type" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Pre Wedding" checked>
                                <label class="form-check-label" for="inlineRadio1">Pre-Wedding</label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" required name="function_type" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Wedding">
                                <label class="form-check-label" for="inlineRadio2">Wedding</label>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-1 pb-1">
                        <div class="col-12 radio-lebel">Function Time</div>
                        <div class="col-12">
                            <div class="form-check-inline">
                                <input type="radio" required class="form-check-input" value="Evening" name="function_time">
                                <label class="form-check-label">Evening</label>
                            </div>
                            <div class="form-check-inline">
                                <input type="radio" required class="form-check-input" value="Day" name="function_time" checked>
                                <label class="form-check-label">Day</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
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
    $(document).ready(function() {
        $('#room').hide().prop('disabled', true);
        $('#guest').hide().prop('disabled', true);
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd', // Set your desired date format
            minDate: 0, // Disables past dates
            // beforeShowDay: function(date) {
            //     // Disable dates that come from the database (assuming they are in an array)
            //     var disabledDates = @json(1);
            //     var stringDate = $.datepicker.formatDate('yy-mm-dd', date);
            //     return [disabledDates.indexOf(stringDate) === -1];
            // }
        });
    });




    $(document).on('change', '#vendor', function() {
        let vendor_id = $(this).val();


        // alert(status);
        $.ajax({
            type: "GET",
            url: "{{ route('admin.getProduct') }}",
            data: {
                'vendor_id': vendor_id
            },
            success: function(data) {
                //console.log(data);
                $("#product").html(data);
            }
        });

    });

    $(document).on('change', '#product', function() {
        let category_id = $(this).val();
        if (category_id == 1) {
            $('#room').show().prop('disabled', false);
            $('#guest').show().prop('disabled', false);
        }

        if (category_id == 6) {
            $('#guest').show().prop('disabled', false);
        }


    });
</script>
</script>

@endsection