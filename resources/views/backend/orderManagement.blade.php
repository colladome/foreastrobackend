@extends('backend.layouts.app')
<!-- Include jQuery UI datepicker -->


<!-- end datepicker -->
@section('content')
<div class="tab-content">
    <div class="tab-pane fade in active show" id="installed">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    @include('messages')
                    <div class="headingBtn">
                        <h4>Real Weddings</h4>
                        <a class="btn btn-info" href="{{ route('admin.productBooking') }}">ADD NEW</a>
                    </div>
                    <hr class="border border-secondary">
                    <form action="{{ route('admin.filterOrder') }}" method="GET">
                        <div class="row">

                            <div class="col-sm-2">
                                <select data-placeholder="-- Select Vendor--" name="vendor_id" class="form-control form-select chosen-select">
                                    <option></option>
                                    @foreach($vendors as $vendor)
                                    @if(! isset($request->vendor_id))
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                    @else
                                    <option value="{{ $vendor->id }}" {{$request->vendor_id == $vendor->id ? 'selected':''}}>{{ $vendor->name }}</option>

                                    @endif
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select data-placeholder="-- Select Category--" name="category_id" class="form-control form-select chosen-select">
                                    <option></option>
                                    @foreach($categories as $category)
                                    @if(! isset($request->category_id))

                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @else
                                    <option value="{{ $category->id }}" {{ $request->category_id  == $category->id ? 'selected':''}}>{{ $category->name }}</option>
                                    @endif
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select data-placeholder="-- Select Payment Status--" name="payment_status" class="form-control form-select chosen-select">
                                    <option></option>
                                    @if(! isset($request->payment_status))
                                    <option value="pending">Pending</option>

                                    <option value="completed">Completed</option>
                                    @else

                                    <option value="pending" {{ $request->payment_status == 'pending' ? 'selected':'' }}>Pending</option>

                                    <option value="completed" {{$request->payment_status == 'completed' ? 'selected':''}}>Completed</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select data-placeholder="-- Select Order Status--" name="order_status" class="form-control form-select chosen-select">
                                    <option></option>
                                    @if(! isset($request->order_status))
                                    <option value="pending">Pending</option>

                                    <option value="completed">Completed</option>
                                    @else


                                    <option value="pending" {{$request->order_status == 'pending' ? 'selected':''}}>Pending</option>

                                    <option value="completed" {{$request->order_status == 'completed' ? 'selected':''}}>Completed</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">

                                    <input type="text" id="from_date" name="from_date" placeholder="from date" class="form-control datepickerdate1">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">

                                    <input type="text" id="to_date" name="to_date" placeholder="to date" class="form-control datepickerdate2">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>

                    <!--table start-->
                    <table id="user" class="display" style="width:100%">
                        <thead class="bg-light">
                            <tr>
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Vendor</th>
                                <th>Email</th>
                                <th>Number Of Item</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Total Amount</th>
                                <th>Booking Date</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Order Detial</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)

                            @php $vendor= []; @endphp

                            @foreach($order->order as $orderlist)

                            @php

                            $vendorName = App\Models\User::where('id', $orderlist->vendor_id)->first();

                            $vendor[] = $vendorName->name;

                            @endphp
                            @endforeach
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->billing_name }}</td>
                                <td>{{ implode(',', $vendor) }}</td>
                                <td>{{ $order->billing_email }}</td>
                                <td>{{ $order->number_of_item }}</td>
                                <td>{{ $order->state }}</td>
                                <td>{{ $order->city }}</td>
                                <td>{{ $order->total_amount }}</td>
                                <td>{{ date('j M Y', strtotime($order->created_at)) }}</td>
                                <td class="">



                                    <!-- <a href ="{{ route('admin.masterTable.destroy', $order->id) }}" class="btn btn-danger">Delete</a> -->

                                    <!-- <a href="#" class="btn btn-danger deleteButton" data-item-id="{{-- $order->id --}}"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                                    <!-- Example single danger button -->
                                    <div class="btn-group">
                                        @if($order->payment_status == 'completed')

                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Completed
                                        </button>

                                        @else

                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Pending
                                        </button>
                                        @endif

                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.changePaymentStatusActive', $order->id) }}">Completed</a>
                                            <a class="dropdown-item" href="{{ route('admin.changePaymentStatusInActive', $order->id) }}">Pending</a>

                                        </div>
                                </td>

                                <td class="">

                                    <!-- <a href="{{-- route('admin.masterTable.edit', $order->id) --}}" class="btn btn-success">Edit</a> -->

                                    <!-- <a href ="{{ route('admin.masterTable.destroy', $order->id) }}" class="btn btn-danger">Delete</a> -->

                                    <!-- <a href="#" class="btn btn-danger deleteButton" data-item-id="{{-- $order->id --}}"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                                    <!-- Example single danger button -->
                                    <div class="btn-group">
                                        @if($order->order_status == 'completed')

                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Completed
                                        </button>

                                        @else

                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Pending
                                        </button>
                                        @endif

                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.changeBookingStatusActive', $order->id) }}">Completed</a>
                                            <a class="dropdown-item" href="{{ route('admin.changeBookingStatusInActive', $order->id) }}">Pending</a>

                                        </div>
                                </td>


                                </td>

                                <td><a href="{{ route('admin.orderDetial', $order->id) }}" class="btn btn-success">view</a></td>

                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Number Of Item</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Total Amount</th>
                                <th>Booking Date</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Order Detial</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="available">
        <div class="row" id="available-addons-content">
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        new DataTable('#user');
        $("#from_date").datepicker({
            dateFormat: 'yy-mm-dd', // Set your desired date format
        });
        $("#to_date").datepicker({
            dateFormat: 'yy-mm-dd', // Set your desired date format
        });

    });
    $(".chosen-select").chosen()
</script>
@endsection