@extends('backend.layouts.app')
@section('content')
<div class="tab-content">
    <div class="tab-pane fade in active show" id="installed">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    @include('messages')
                    <h4>Payment Management</h4>
                    <div class="my-3">
                        <form action="{{ route('admin.paymentFilter') }}" method="get" class="d-flex flex-wrap gap-3">
                                <div class="col-md-3 px-0">
                                <label for="" class="form-label">Astrologer Name</label>
                              <input type"text" value="{{ $astroName ?? ''}}" class="form-control" name="astrologer_name" placeholder="Astrologer Name">
                            </div>
                            <div class="col-md-3 px-0">
                                <label for="" class="form-label">Date</label>
                                <select class="form-control" name="date">
                                    <option value="">--Select--</option>
                                    <option value="daily" {{ $date == 'daily' ? 'selected':'' }}>Daily</option>
                                    <option value="weekly" {{ $date == 'weekly' ? 'selected':'' }}>Weekly</option>
                                    <option value="monthly" {{ $date == 'monthly' ? 'selected':'' }}>Monthly</option>
                                </select>
                            </div>
                            <div class="col-md-3 px-0">
                                <label for="" class="form-label">Payment Status</label>
                                <select class="form-control" name="payment_status">
                                    <option value="">--Select--</option>
                                    <option value="pending" {{$paymentStatus == 'pending' ? 'selected':'' }}>Pending</option>
                                    <option value="completed" {{$paymentStatus == 'completed' ? 'selected':'' }}>Completed</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success ">Fillter</button>
                        </form>
                    </div>
                    @if(!empty($astroName))
                    <div class="my-3">
                        
                        
                        <div class="row gutters-10">
         <div class="col-3">
            <a href="{{ route('admin.listUser') }}">
               <div class="bg-grad-2 text-white rounded-lg mb-4 overflow-hidden">
                  <div class="px-3 pt-3">
                     <div class="opacity-50">
                        <span class="fs-12 d-block">Total Calls/chats</span>
                        Astrologer
                     </div>
                     <div class="h3 fw-700 mb-3">
                        {{ $totalCallAndChats }}
                     </div>
                  </div>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                     <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                  </svg>
               </div>
            </a>
         </div>
         
         
         
         
         
          <div class="col-3">
            <a href="{{ route('admin.listUser') }}">
               <div class="bg-grad-2 text-white rounded-lg mb-4 overflow-hidden">
                  <div class="px-3 pt-3">
                     <div class="opacity-50">
                        <span class="fs-12 d-block">Total Amount Received</span>
                        Astrologer
                     </div>
                     <div class="h3 fw-700 mb-3">
                        {{ $totalAmount }}
                     </div>
                  </div>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                     <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                  </svg>
               </div>
            </a>
         </div>
      
         </div>
                        
                        
                        
                        
                        
                        </div>
                        @endif
                    <!--table start-->
                    <table id="payment" class="display" style="width:100%">
                        <thead class="bg-light">
                            <tr>
                                <th>S.N</th>
                                <th>User Name</th>
                                <th>Astrologer Name</th>
                                <th>Payment Done For</th>
                                <th>Date & Time</th>
                                <th>Amount Received</th>
                                <th>Call/Chat Id</th>
                                <th>Astrologer Payment Status</th>
                                <th>User APK Version</th>
                                <th>Astrologer APK Version</th>
                                
                                <th>View Chat History</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                            
                            @php   
                            
                            $number = (float) str_replace(',', '', $payment->total_amount);

                            $roundedValue = round($number);
                            
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->user->name ?? '-' }}</td>
                                <td>{{ $payment->astrologer->name ?? '-' }}</td>
                                <td>{{ $payment->type }}</td>
                                <td>{{ date('d-m-Y', strtotime($payment->created_at)) }} {{ date('g:i A', strtotime($payment->created_at)) }}</td>

                                <td>{{ round($roundedValue) }}</td>

                                <td>{{ $payment->communication_id }}</td>

                                <td>
                                    <div class="btn-group">
                                        @if($payment->payment_status == 'pending')

                                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Pending
                                        </button>

                                        @else




                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Completed
                                        </button>
                                        @endif

                                        <!--<div class="dropdown-menu">-->
                                        <!--    <a class="dropdown-item" href="{{ route('admin.payment.completed', $payment->id) }}">Completed</a>-->
                                        <!--    <a class="dropdown-item" href="{{ route('admin.payment.pending', $payment->id) }}">Pending</a>-->

                                        <!--</div>-->
                                </td>
                                <td>{{ $payment->user->version ?? '-' }}</td>
                                <td>{{ $payment->astrologer->version ?? '-' }}</td>
                                
                                @if($payment->type=='chat')
                                 <td><a class="btn btn-primary" href="{{ route('admin.chatHistory', $payment->id) }}" title="View">View Chat</a></td>
                                 @else
                                 <td>-</td>
                                 @endif
                                <td style="font-size: 18px;">
                                    <!-- <a href ="{{-- route('admin.staff.edit', $user->id) --}}" class="btn btn-success">Edit</a>   -->
                                    <!-- <a href ="{{-- route('admin.staff.destroy', $staff->id) --}}" class="btn btn-danger">Delete</a> -->
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('admin.payment.view', $payment->id) }}" title="View">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger deleteButton" data-item-id="{{ $payment->id }}"><i class="fa fa-trash" aria-hidden="true"></i>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S.N</th>
                                <th>User Name</th>
                                <th>Astrologer Name</th>
                                <th>Payment Done For</th>
                                <th>Date & Time</th>
                                <th>Amount Received</th>
                                <th>Call/Chat Id</th>
                                <th>Astrologer Payment Status</th>
                                <th>User APK Version</th>
                                <th>Astrologer APK Version</th>
                                <th>View Chat History</th>
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