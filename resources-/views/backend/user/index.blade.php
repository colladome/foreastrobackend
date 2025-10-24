@extends('backend.layouts.app')
@section('content')
<div class="tab-content">
   <div class="tab-pane fade in active show" id="installed">
      <div class="row">
         <div class="col-lg-12 mx-auto">
            <div class="card">
               @include('messages')
               <h4>Users</h4>
               <!--table start-->
               <table id="user" class="display" style="width:100%">
                  <thead class="bg-light">
                     <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Date of Joining</th>
                        <th>Wallet Amount</th>
                        <th>Total number of calls completed</th>
                        <th>Total chats completed</th>
                        <th>APK Version</th>
                        <th>Status</th>
                        <th>View Transitions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($users as $user)

                     @php

                     $countChat = App\Models\Communication::where(['user_id' => $user->id,'status'=>'accept','type'=>'chat'])->count();
                     $countCall = App\Models\Communication::where(['user_id' => $user->id,'status'=>'accept'])->where('type', '!=', 'chat')->count();

                     @endphp
                     <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile_number }}</td>

                        <td>{{ date('d-m-Y', strtotime($user->created_at)) }}</td>
                        </td>
                        <td>{{ round($user->wallet) }}</td>
                        <td>{{ $countCall }}</td>
                        <td>{{ $countChat }}</td>
                        <td>{{ $user->version ?? '-' }}</td>
                        <td>
                           <div class="btn-group">
                              @if($user->status == 1)

                              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Unblock
                              </button>

                              @else

                              <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Block
                              </button>
                              @endif

                              <div class="dropdown-menu">
                                 <a class="dropdown-item" href="{{ route('admin.user.active', $user->id) }}">Unblock</a>
                                 <a class="dropdown-item" href="{{ route('admin.user.inActive', $user->id) }}">Block</a>

                              </div>
                        </td>
                        <!--<td style="font-size: 18px;">-->
                           <!-- <a href ="{{-- route('admin.staff.edit', $user->id) --}}" class="btn btn-success">Edit</a>   -->
                           <!-- <a href ="{{-- route('admin.staff.destroy', $staff->id) --}}" class="btn btn-danger">Delete</a> -->
                           <!--<a href="#" class="btn btn-danger deleteButton" data-item-id="{{ $user->id }}"><i class="fa fa-trash" aria-hidden="true"></i>-->
                        <!--</td>-->
                        
                        
                        <td><a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('admin.user.walletTransactionId', $user->id) }}" title="View">
                                        <i class="las la-eye"></i></td>
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
                        <th>Total number of calls completed</th>
                        <th>Total chats completed</th>
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

      let route = "{{ route('admin.user.destroy', 'PLACEHOLDER_ID') }}";
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