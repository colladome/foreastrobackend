@extends('backend.layouts.app')
@section('content')
<div class="tab-content">
    <div class="tab-pane fade in active show" id="installed">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    @include('messages')

                    <div class="headingBtn">
                        <h4>Astrologers</h4>
                        <a class="btn btn-info" href="{{ route('admin.astrologerr.create') }}">ADD NEW</a>
                    </div>
                    <!--table start-->
                    <table id="user" class="display" style="width:100%">
                        <thead class="bg-light">
                            <tr>
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Date of Joining</th>
                                <th>Service Type</th>
                                <th>Adhar Id</th>
                                <th>PAN Id</th>
                                <th>Wallet Amount</th>
                                <th>Onboarding Status</th>
                                <th>APK version</th>
                                <th>Status</th>
                                <th>Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($astrologers as $astrologer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $astrologer->name }}</td>
                                <td>{{ $astrologer->email }}</td>
                                <td>{{ $astrologer->mobile_number }}</td>

                                <td>{{ date('d-m-Y', strtotime($astrologer->created_at)) }}</td>

                                <td>{{ $astrologer->specialization }}</td>
                                <td>{{ $astrologer->adhar_id }}</td>
                                <td>{{ $astrologer->pan_number }}</td>
                                
                                  @php
                                $communicationTotalAmount = \App\Models\Communication::where([
                                    'astrologer_id' => $astrologer->id,
                                    'status' => 'accept',
                                ])
                                ->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()])
                                ->sum('total_amount');
                            
                                $netAmountAstrologer = $communicationTotalAmount - 
                                    (($communicationTotalAmount * $astrologer->commission_percent) / 100);
                            
                                $liveTotalAmount = \App\Models\AstrologerLive::where('astrologer_id', $astrologer->id)
                                    ->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()])
                                    ->sum('amount');
                            
                                $boostAmount = \App\Models\Boost::where('astrologer_id', $astrologer->id)
                                    ->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()])
                                    ->sum('amount');
                            
                                $astrologerWallet = $netAmountAstrologer - ($boostAmount + $liveTotalAmount + $astrologer->wallet);
                            @endphp
                                
                                
                                
                                <td>{{ round($astrologerWallet) }}</td>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                <td>@if($astrologer->is_onboarding_completed=='1')<span class="badge badge-success px-5 py-3 text-white">Completed</span>
                                    @else<span class="badge badge-warning px-5 py-3">Pending</span>
                                    @endif</td>
                                    
                                    <td>{{ $astrologer->version }}</td>

                                <td>
                                    <div class="btn-group">
                                        @if($astrologer->profile_status == 'pending')

                                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Pendind
                                        </button>

                                        @elseif($astrologer->profile_status == 'onboard')

                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Onboard
                                        </button>
                                        @elseif($astrologer->profile_status == 'rejected')

                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Rejected
                                        </button>
                                        @elseif($astrologer->profile_status == 'trainee')
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Trainee
                                        </button>
                                        @elseif($astrologer->profile_status == 'approved')
                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Approved
                                        </button>
                                        @else
                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Blocked
                                        </button>
                                        @endif

                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.astrologer.active', ['id'=> $astrologer->id, 'status' => 'pending']) }}">Pending</a>
                                            <a class="dropdown-item" href="{{ route('admin.astrologer.active', ['id'=> $astrologer->id, 'status' => 'onboard']) }}">Onboard</a>
                                            <a class="dropdown-item" href="{{ route('admin.astrologer.active', ['id'=> $astrologer->id, 'status' => 'trainee']) }}">Trainee</a>
                                            <a class="dropdown-item" href="{{ route('admin.astrologer.active', ['id'=> $astrologer->id, 'status' => 'approved']) }}">Approved</a>
                                            <a class="dropdown-item" href="{{ route('admin.astrologer.active', ['id'=> $astrologer->id, 'status' => 'blocked']) }}">Blocked</a>
                                            <a class="dropdown-item rejectOption" 
                                            data-url="{{ route('admin.astrologer.reject', $astrologer->id) }}">
                                            Rejected
                                            </a>


                                        </div>
                                </td>
                                <td style="font-size: 18px;">
                                    <!-- <a href ="{{-- route('admin.staff.edit', $astrologer->id) --}}" class="btn btn-success">Edit</a>   -->
                                    <!-- <a href ="{{-- route('admin.staff.destroy', $staff->id) --}}" class="btn btn-danger">Delete</a> -->
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('admin.astrologer.view', $astrologer->id) }}" title="View">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <!--<a href="#" class="btn btn-danger deleteButton" data-item-id="{{ $astrologer->id }}"><i class="fa fa-trash" aria-hidden="true"></i>-->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Date of Joining</th>
                                <th>Service Type</th>
                                <th>Adhar Id</th>
                                <th>PAN Id</th>
                                <th>Onboarding Status</th>
                                <th>Status</th>
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


<!-- Rejection Modal -->
<div class="modal fade" id="rejectionModal" tabindex="-1" aria-labelledby="rejectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="rejectionForm" method="POST" action="">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectionModalLabel">Reject Astrologer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please provide a remark for rejection:</p>
                    <textarea class="form-control" name="remark" required rows="3"
                        placeholder="Enter rejection reason..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </div>
        </form>
    </div>
</div>



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
    });

    // jQuery to show the confirmation modal and handle delete action
    $('.deleteButton').click(function() {
        var itemId = $(this).data('item-id');

        let route = "{{ route('admin.astrologer.destroy', 'PLACEHOLDER_ID') }}";
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
<script>
    $(document).ready(function () {
    // Handle Reject Option
    $('.rejectOption').click(function (e) {
        e.preventDefault();
        let url = $(this).data('url');
        $('#rejectionForm').attr('action', url); // set form action dynamically
        $('#rejectionModal').modal('show');
    });
});

</script>
@endsection