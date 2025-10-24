@extends('backend.layouts.app')
@section('content')

<section class="product-single-items ">
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="row">
                    <div class="col-md-12 cart p-4">
                        <div class="title mt-3">
                            <div class="row">
                                <div class="col">
                                    @include('messages')
                                    <h5>Payment Transaction</h5>
                                    <!-- <div class="my-3">
                                        <span class="text-warning">Transaction</span>
                                        <h6>#00232323</h6>
                                    </div> -->
                                    <div class="d-flex flex-wrap gap-5">
                                        <div class="">
                                            <label class="fs-6">Amount</label>
                                            <h6><i class="fas fa-rupee-sign"></i> {{ number_format($payment->total_amount, 2) }}</h6>
                                        </div>
                                        <div class="">
                                            <label class="fs-6">Date</label>
                                            <h6>{{ $payment->created_at->format('F d, Y') }}</h6>
                                        </div>
                                        <div class="">
                                            <label class="fs-6">Status</label>
                                            <h6 class="text-success">Paid</h6>
                                        </div>
                                    </div>
                                    <hr class="border-dark">

                                    <div class="mb-3">
                                        <h5 class="">Astrologer Payment Details</h5>
                                    </div>
                                    <div class="d-flex flex-wrap gap-5">
                                        <div class="">
                                            <label class="fs-6">Bankk Name</label>
                                            <h6>{{ $bank->name ?? '-'}}</h6>
                                        </div>
                                        <div class="">
                                            <label class="fs-6">IFSC</label>
                                            <h6>{{ $bank->ifsc ?? '-'}}</h6>
                                        </div>


                                        <div class="">
                                            <label class="fs-6">Account Number</label>
                                            <h6 class="">{{ $bank->account_number ?? '-' }}</h6>
                                        </div>


                                    </div>
                                    <div class="d-flex flex-wrap gap-5 my-3">
                                        <div class="">
                                            <label class="fs-6">Paid Amount</label>

                                            @php
                                            $commission = ($payment->total_amount*$payment->astrologer->commission_percent)/100;

                                            $paidAmount = $payment->total_amount-$commission;
                                            @endphp



                                            <h6><i class="fas fa-rupee-sign"></i>{{ number_format($paidAmount, 2) }}</h6>
                                        </div>
                                        <div class="">
                                            <label class="fs-6">Date</label>
                                            <h6>{{ date('F d, Y', strtotime($payment->astrologer_payment_date)) }}</h6>
                                        </div>
                                        <div class="">
                                            <label class="fs-6">Payment Status</label>
                                            @if($payment->payment_status=='pending')
                                            <h6 class="text-warning">{{ $payment->payment_status }}</h6>
                                            @else
                                            <h6 class="text-success">{{ $payment->payment_status }}</h6>
                                            @endif
                                        </div>
                                    </div>
                                    <hr class="border-dark">

                                    <div class="mb-3">
                                        <h5 class="">User Details</h5>
                                    </div>
                                    <div class="d-flex flex-wrap gap-5">
                                        <div class="">
                                            <label class="fs-6">Full Name</label>
                                            <h6>{{ $payment->user->name }}</h6>
                                        </div>
                                        <div class="">
                                            <label class="fs-6">Email Address</label>
                                            <h6>{{ $payment->user->email }}</h6>
                                        </div>
                                        <div class="">
                                            <label class="fs-6">Phone Number</label>
                                            <h6 class="">{{ $payment->user->mobile_number }}</h6>
                                        </div>
                                    </div>
                                    <hr class="border-dark">


                                    <div class="mb-3">
                                        <h5 class="">Astrologer Details</h5>
                                    </div>
                                    <div class="d-flex flex-wrap gap-5">
                                        <div class="">
                                            <label class="fs-6">Full Name</label>
                                            <h6>{{ $payment->astrologer->name }}</h6>
                                        </div>
                                        <div class="">
                                            <label class="fs-6">Email Address</label>
                                            <h6>{{ $payment->astrologer->email }}</h6>
                                        </div>
                                        <div class="">
                                            <label class="fs-6">Phone Number</label>
                                            <h6 class="">{{ $payment->astrologer->mobile_number }}</h6>
                                        </div>
                                    </div>
                                    <hr class="border-dark">


                                    <div class="mb-3">
                                        <h5 class="">Call / Chat Details</h5>
                                    </div>
                                    <div class="d-flex flex-wrap gap-5">
                                        <div class="">
                                            <label class="fs-6">Call / Chat ID</label>
                                            <h6>#{{ $payment->communication_id }}</h6>
                                        </div>
                                        <!-- <div class="">
                                            <label class="fs-6">Session ID</label>
                                            <h6>#2334</h6>
                                        </div> -->
                                        @php
                                        if($payment->time >= 60) { $dividend=$payment->time;
                                            $divisor = 60;

                                            // Quotient
                                            $quotient = intdiv($dividend, $divisor);
                                            
                                            
                                           

                                            // Remainder
                                            $remainder = $dividend % $divisor;
                                            }else{

                                            // Quotient
                                            $quotient = 0;

                                            // Remainder
                                            $remainder = $payment->time;
                                            }


                                            @endphp
                                            <div class="">
                                                <label class="fs-6">Duration</label>
                                                <h6 class="">{{ $quotient }}:{{ $remainder }}:00</h6>
                                            </div>
                                            <div class="">
                                                <label class="fs-6">Amount Received</label>
                                                <h6 class=""><i class="fas fa-rupee-sign"></i> {{ number_format($payment->total_amount, 2) }}</h6>
                                            </div>
                                    </div>
                                    <hr class="border-dark">
                                </div>


                            </div>
                        </div>
















                    </div>

                </div>

            </div>

        </div>
    </div>

</section>

@endsection