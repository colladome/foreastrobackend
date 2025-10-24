@extends('backend.layouts.app')
@section('content')

<section class="product-single-items ">
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="row">
                    <div class="col-md-12 cart">
                        <div class="title mt-3">
                            <div class="row">
                                <div class="col">
                                    @include('messages')
                                    <h4><b>Booking Detials</b></h4>
                                </div><br>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-2">
                                <p><strong>Order Id: </strong>{{ $order->sky_order_id }}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>Name: </strong>{{ $order->billing_name }}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>Email: </strong>{{ $order->billing_email }}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>State: </strong>{{ $order->state }}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>City: </strong>{{ $order->city }}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>Address: </strong>{{ $order->billing_address }}</p>
                            </div>

                            <div class="col-sm-2">
                                <p><strong>Booking Date: </strong>{{ date('j M Y', strtotime($order->created_at))}}</p>
                            </div>


                        </div>


                        <div class="row mt-5">
                            <div class="col-sm-4">
                                <strong>Product Name</strong>
                            </div>
                            <div class="col-sm-4">
                                <strong>Detials</strong>
                            </div>


                        </div>


                        @foreach($order->order as $item)

                        @php $dates = []; @endphp

                        @foreach($item->booking_date as $date)
                        @php $dates[] = date('j M Y', strtotime($date)); @endphp

                        @endforeach


                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="{{  asset('storage/' . $item->image['file']) }}" width="100px;" height="100px;">
                                    </div>
                                    <div class="col-sm-3">
                                        {{ $item->product_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">

                                @php
                                $type = App\Models\Backend\Category::where('id',$item->category_id)->first();
                                @endphp
                                <div class="row">
                                    <span><strong>Type: </strong>{{ $type->name }}</span>
                                </div>
                                @if($item->category_id == 1 || $item->category_id == 6)
                                <div class="row">
                                    <span><strong>Number Of Gust: </strong>{{ $item->number_of_guest }}</span>
                                </div>
                                @endif

                                @if($item->category_id == 1)
                                <div class="row">
                                    <span><strong>Number Of Rooms: </strong>{{ $item->number_of_room }}</span>
                                </div>
                                @endif


                                <div class="row">
                                    <span><strong>Event Dates: </strong>{{implode(",",$dates) }}</span>
                                </div>
                                <div class="row">
                                    <span><strong>Price : </strong>Rs.{{ $item->price }}</span>
                                </div>
                            </div>

                        </div>

                        @php $countProduct = $loop->count; @endphp
                        @endforeach





                        <hr>


                        <div class="row">
                            <div class="col-md-3">
                                <span><strong>Number of Items</strong></span>
                            </div>
                            <div class="col-md-3">
                                <span><strong>Total Price</strong></span>
                            </div>
                            <div class="col-md-3">
                                <span><strong>Payment Status</strong></span>
                            </div>
                            <div class="col-md-3">
                                <span><strong>Order Status</strong></span>
                            </div>

                        </div>


                        <div class="row mt-2">
                            <div class="col-md-3">
                                <span>{{ $countProduct }}</span>
                            </div>
                            <div class="col-md-3">
                                <span><strong>{{ $order->total_amount }}</strong></span>
                            </div>
                            <div class="col-md-3">
                                <span><strong>{{ $order->payment_status }}</strong></span>
                            </div>
                            <div class="col-md-3">
                                <span><strong>{{ $order->order_status }}</strong></span>
                            </div>

                        </div>
                        <div class="row mt-5">
                        </div>




                    </div>

                </div>

            </div>

        </div>
    </div>

</section>

@endsection