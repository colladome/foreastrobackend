@extends('backend.layouts.app')
@section('content')
<div class="tab-content">
    <div class="tab-pane fade in active show" id="installed">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    @include('messages')
                    <h4>User Wallet Transactions</h4>
                    <!--table start-->
                    <table id="payment" class="display" style="width:100%">
                        <thead class="bg-light">
                            <tr>
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Order ID</th>
                                <th>Payment Id</th>
                                <th>Amount</th>
                                <th>GST</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Time</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                            
                            
                            @php
                            
                            
                            $gst = ($payment->amount*18/100);
                           
                            
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->name }}</td>
                                <td>{{ $payment->order_id }}</td>
                                <td>{{ $payment->payment_id }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $gst }}</td>
                                <td>@if($payment->status == 'paid')<span class="badge badge-success w-auto">{{ $payment->status }}</span>@else<span class="badge badge-danger w-auto">{{ $payment->status }}</span>@endif</td>
                                <td>{{ date('d-m-Y', strtotime($payment->date)) }}</td>
                                <td>

                                    @php
                                    $date = strtotime($payment->date);

                                    $formattedTime = date('h:i A', $date);

                                    @endphp

                                    {{ $formattedTime }}


                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Order ID</th>
                                <th>Payment Id</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </tfoot>
                    </table>
                    <!--table end--->

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
        new DataTable('#payment');
    });
</script>
@endsection