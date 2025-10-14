@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h1 class="h2 fs-16 mb-0">Payout Details</h1>
    </div>
    <div class="card-body">


    </div>
    <div class="mb-3">


    </div>
    <div class="row gutters-5">
        <div class="col text-md-left text-center">

            <address>
                <table>
                    <tbody>
                        <tr>
                            <td class="text-main text-bold">Name</td>
                            <td class="text-info text-bold text-right">{{ $astrologer->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">Email</td>
                            <td class="text-right">
                                {{ $astrologer->email }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">Phone</td>
                            <td class="text-right">{{ $astrologer->mobile_number }}</td>
                        </tr>



                    </tbody>
                </table>


        </div>
        <div class="col-md-4 ml-auto">
            <table>
                <tbody>
                    <tr>
                        <td class="text-main text-bold">Account Holder Name</td>
                        <td class="text-info text-bold text-right"> {{ $astrologer->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-main text-bold">Account No.</td>
                        <td class="text-right">
                            {{ $bank->account_number ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-main text-bold">IFSC</td>
                        <td class="text-right">{{ $bank->ifsc ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="text-main text-bold">
                            Bank Name
                        </td>
                        <td class="text-right">
                            {{ $bank->name ?? '' }}
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    <hr class="new-section-sm bord-no">
    <div class="row">
        <div class="col-lg-12 table-responsive">
            <table class="table-bordered  invoice-summary table">
                <thead>
                    <tr class="bg-trans-dark">
                        <th data-breakpoints="lg" class="min-col">#</th>
                        <th width="10%">User Name</th>
                        <th class="text-uppercase">Astrologer Name</th>
                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Call Id
                        </th>
                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Communication Type
                        </th>
                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Call Time(min)
                        </th>
                        <th data-breakpoints="lg" class="text-uppercase">Total Amount</th>
                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Commission Amount
                        </th>
                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Coupon Code
                        </th>
                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Coupon Discount Amount
                        </th>




                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Payment Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($communications as $communication)


                    @php $commission = ($communication->total_amount*$communication->astrologer->commission_percent)/100 @endphp

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ $communication->user->name ?? '-'}}
                        </td>
                        <td>
                            {{ $communication->astrologer->name ?? '-' }}
                        </td>
                        <td>
                            {{ $communication->communication_id ?? '-' }}
                        </td>
                        <td class="text-center">
                            {{ $communication->type }}
                        </td>
                        <td class="text-center">
                            {{ number_format($communication->time/60,2) }}   
                        </td>
                        <td class="text-center">
                            {{ number_format($communication->total_amount, 2) }}
                        </td>
                        <td class="text-center">
                            {{ number_format($commission, 2) }}
                        </td>
                        <td class="text-center">
                            {{ $communication->coupon_applied ?? '-' }}
                        </td>


                        <td class="text-center">
                            {{ $communication->coupon_discount_amount }}
                        </td>


                        <td class="text-center">
                            {{ $communication->payment_status }}
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>



    <!------------------------>
    <h4>Astrologer Live Histroy</h4>
    <div class="row">
        <div class="col-lg-12 table-responsive">
            <table class="table-bordered  invoice-summary table">
                <thead>
                    <tr class="bg-trans-dark">
                        <th data-breakpoints="lg" class="min-col">#</th>

                        <th class="text-uppercase">Astrologer Name</th>
                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Live Id
                        </th>
                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Time(Min)
                        </th>
                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Per Min Charge
                        </th>
                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Amount
                        </th>
                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Date
                        </th>






                    </tr>
                </thead>
                <tbody>
                    @foreach($lives as $live)


                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $live->astrologer->name }}
                        </td>
                        <td>
                            {{ $live->live_id }}
                        </td>
                        <td>
                            {{ number_format($live->time/60, 2); }}
                        </td>
                        <td>
                            {{ $live->astrologer_live_charges_per_min }}
                        </td>
                        <td class="text-center">
                            {{ $live->amount }}
                        </td>

                        <td class="text-center">
                            {{ date('d-m-Y', strtotime($live->created_at)) }}
                        </td>


                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!------------------->


     <!------------------------>
     <h4>Astrologer Boost Histroy</h4>
    <div class="row">
        <div class="col-lg-12 table-responsive">
            <table class="table-bordered  invoice-summary table">
                <thead>
                    <tr class="bg-trans-dark">
                        <th data-breakpoints="lg" class="min-col">#</th>

                        <th class="text-uppercase">Astrologer Name</th>
                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Amount
                        </th>
                        
                       
                        <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                            Date
                        </th>






                    </tr>
                </thead>
                <tbody>
                    @foreach($boosts as $boost)


                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $live->astrologer->name }}
                        </td>
                        <td>
                            {{ $live->amount }}
                        </td>
                       
                        

                        <td class="text-center">
                            {{ date('d-m-Y', strtotime($boost->created_at)) }}
                        </td>


                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!------------------->









    <div class="row justify-content-between">

        <div class="col-md-4">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <strong class="text-muted">Total Amount :</strong>
                        </td>
                        <td>
                            {{ $payout->total_amount }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong class="text-muted">Total Commission Amount :</strong>
                        </td>
                        <td>
                            {{ $payout->commission_amount }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong class="text-muted">Total Coupon Amount :</strong>
                        </td>
                        <td>
                            {{ $payout->total_coupon_discount }}
                        </td>
                    </tr>



                    <tr>
                        <td>
                            <strong class="text-muted">Total Live Amount :</strong>
                        </td>
                        <td>
                            {{ $payout->live_amount }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong class="text-muted">Total Boost Amount :</strong>
                        </td>
                        <td>
                            {{ $payout->boost_amount }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong class="text-muted">Paid Amount :</strong>
                        </td>
                        <td class="text-muted h5">

                            {{ $payout->paid_amount }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>





    </div>


</div>
</div>
@endsection

@section('script')

@endsection