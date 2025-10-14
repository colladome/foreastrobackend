@extends('backend.layouts.app')

@section('content')

    <div class="tab-content">
        <div class="tab-pane fade in active show" id="installed">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        @include('messages')
                        <div class="headingBtn">
                            <h2>Roles</h2>
                            <a class="btn btn-info" href="{{ route('admin.masterTable.role.create') }}">ADD</a>
                        </div>
                        <div class="tableDesign">
                        <table id="example" class="display">
                    <thead class="bg-light">
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>                           
                            <th>Action</th>                        
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                           
                                <a href ="{{ route('admin.masterTable.role.edit', $role->id) }}" class="btn btn-success">Edit</a>  
                             
                                <!-- <a href ="{{ route('admin.masterTable.role.destroy', $role->id) }}" class="btn btn-danger">Delete</a> -->
                                <a href ="#"  class="btn btn-danger deleteButton" data-item-id="{{ $role->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            
                            </td>
                            
                        </tr>
                        @endforeach
                    
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>                           
                            <th>Action</th>                            
                        </tr>
                    </tfoot>
                </table>
    </div>


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
        Are you sure you want to delete this item?
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
    	$(document).ready( function () {
			new DataTable('#example');
} );

// jQuery to show the confirmation modal and handle delete action
$('.deleteButton').click(function() {
    var itemId = $(this).data('item-id');
    var deleteLink = '<a href="{{ route('admin.masterTable.role.destroy', 'PLACEHOLDER_ID') }} class="btn btn-danger">Delete</a>';
    deleteLink = deleteLink.replace('PLACEHOLDER_ID', itemId);
    $('.deleteLinkContainer').html(deleteLink);
    $('#confirmationModal').modal('show');
  });

  $('#confirmDelete').click(function() {
    
    
    // Close the modal
    $('#confirmationModal').modal('hide');
  });
</script>

@endsection


