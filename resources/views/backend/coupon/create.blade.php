@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card">
<div class="card-header mb-2">
    <h3 class="h6">Add Coupon</h3>
</div>
<form class="form-horizontal"  method="post" action="{{ route('admin.coupon.store') }}">
    @csrf
     <div class="card-body">
    <div class="form-group row">
        <label class="col-lg-3 col-from-label" for="code">Coupon code</label>
        <div class="col-lg-5">
            <input type="text" placeholder="Coupon code" id="code" name="code" class="form-control" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-from-label">Type</label>

        <div class="col-lg-5">
            <select class="form-control" name="type">
                <option value="chat">Chat</option>
                <option value="audio">Audio</option>
                <option value="video">Video</option>

            </select>
        </div>
    </div>

    <br>
    <div class="form-group row">
        <label class="col-sm-3 control-label" for="start_date">Date</label>
        <div class="col-sm-5">
            <input type="text" name="daterange" class="form-control" value="" placeholder="Date Range" />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-from-label">Discount</label>
        <div class="col-lg-3">
            <input type="number" lang="en" min="0" step="0.01" placeholder="Discount" name="discount" class="form-control" required>
        </div>
        <div class="col-lg-2">
            <select class="form-control" name="discount_type">
                <option value="amount">Amount</option>
                <option value="percent">Percent</option>
            </select>
        </div>
    </div>

    <div class="col-lg-2">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
 </div>
</form>
</div>
</div>
</div>
@endsection