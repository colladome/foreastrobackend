@extends('backend.layouts.app')
@section('content')
<div class="tab-content">
    <div class="tab-pane fade in active show" id="installed">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    @include('messages')
                    <h4>Payouts</h4>

                    <div class="my-3">
                        <form action="{{ route('admin.payoutFilter') }}" method="get" class="d-flex flex-wrap gap-3">

                            <div class="col-md-3 px-0">
                                <label for="" class="form-label">Astrologer Name</label>
                                <input type="text" name="name" value="{{ $name }}" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Name">
                            </div>
                            <div class="col-md-3 px-0">
                                <label for="" class="form-label">Payment Status</label>
                                <select class="form-control" name="payment_status">
                                    <option value="">All</option>
                                    <option value="pending" {{$paymentStatus == 'pending' ? 'selected':'' }}>Pending</option>
                                    <option value="completed" {{$paymentStatus == 'completed' ? 'selected':'' }}>Completed</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success ">Fillter</button>
                        </form>
                    </div>

                    <!--table start-->
                    <table id="payment" class="display" style="width:100%">
                        <thead class="bg-light">
                            <tr>
                                <th>S.N</th>
                                <th>Astrologer Name</th>
                                <th>Total Amount</th>
                                <th>Commission Amount</th>
                                <th>Live Amount</th>
                                <th>Boost Amount</th>
                                <th>Coupon Discount Amount</th>
                                <th>Credit Amount</th>
                                <th>Astrologer Paid Amount</th>
                                <th>Week Start Date</th>
                                <th>Week End Date</th>
                                <th>Astrologer Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payouts as $payout)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payout->astrologer->name ?? '-' }}</td>
                                <td>{{ $payout->total_amount ?? '-' }}</td>
                                <td>{{ $payout->commission_amount ?? '-' }}</td>
                                <td>{{ $payout->live_amount ?? '-' }}</td>
                                <td>{{ $payout->boost_amount ?? '-' }}</td>
                                <td>{{ $payout->coupon_discount_amount ?? '-' }}</td>
                                <td>{{ $payout->credit_amount ?? '-' }}</td>
                                <td>{{ $payout->paid_amount ?? '-' }}</td>
                                <td>{{ date('d-m-Y', strtotime($payout->weekly_start_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($payout->weekly_end_date)) }}</td>



                                <td>
                                    <div class="btn-group">
                                        @if($payout->payment_status == 'pending')

                                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Pending
                                        </button>

                                        @else




                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Completed
                                        </button>
                                        @endif

                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.payout.completed', $payout->id) }}">Completed</a>
                                            <a class="dropdown-item" href="{{ route('admin.payout.pending', $payout->id) }}">Pending</a>

                                        </div>
                                </td>
                                <td style="font-size: 18px;">
                                    <!-- <a href ="{{-- route('admin.staff.edit', $user->id) --}}" class="btn btn-success">Edit</a>   -->
                                    <!-- <a href ="{{-- route('admin.staff.destroy', $staff->id) --}}" class="btn btn-danger">Delete</a> -->
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('admin.payout.view', $payout->id) }}" title="View">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <!-- <a href="#" class="btn btn-danger deleteButton" data-item-id="{{ $payout->id }}"><i class="fa fa-trash" aria-hidden="true"></i> -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S.N</th>
                                <th>Astrologer Name</th>
                                <th>Total Amount</th>
                                <th>Commission Amount</th>
                                <th>Live Amount</th>
                                <th>Coupon Discount Amount</th>
                                <th>Credit Amount</th>
                                <th>Astrologer Paid Amount</th>
                                <th>Week Start Date</th>
                                <th>Week End Date</th>
                                <th>Astrologer Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    <!--table end--->
                    <!-- Confirmation Modal -->
                    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete User?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <span class="deleteLinkContainer"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end model-->
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

    // jQuery to show the confirmation modal and handle delete action
    $('.deleteButton').click(function() {
        var itemId = $(this).data('item-id');

        let route = "{{ route('admin.payment.delete', 'PLACEHOLDER_ID') }}";
        var deleteLink = '<a href="' + route + '">Delete</a>';
        deleteLink = deleteLink.replace('PLACEHOLDER_ID', itemId);
        $('.deleteLinkContainer').html(deleteLink);
        $('#confirmationModal').modal('show');
    });

    $('#confirmDelete').click(function() {

        console.log('Item deleted!');

        // Close the modal
        $('#confirmationModal').modal('hide');
    });
</script>
@endsection