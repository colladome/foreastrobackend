

@extends('backend.layouts.app')

@section('content')

    <div class="tab-content">
        <div class="tab-pane fade in active show" id="installed">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        @include('messages')
                        <div class="headingBtn">
                            <h2>Permissions</h2>
                            <a class="btn btn-info" href="{{ route('admin.masterTable.subCategory.create') }}">ADD NEW</a>
                        </div>
                        

                        <!--table start-->
                <table id="user" class="display" style="width:100%">
                    <thead class="bg-light">
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($subCategories as $subCategory)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $subCategory->name }}</td>
                            <td ><a href ="{{ route('admin.masterTable.subCategory.edit', $subCategory->id) }}" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>  
                            <!-- <a href ="{{ route('admin.masterTable.subCategory.destroy', $subCategory->id) }}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                            <a href ="#"  class="btn btn-danger deleteButton" data-item-id="{{ $subCategory->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                           
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
			new DataTable('#user');
} );

// jQuery to show the confirmation modal and handle delete action
$('.deleteButton').click(function() {
    var itemId = $(this).data('item-id');
    var deleteLink = '<a href="{{ route('admin.masterTable.subCategory.destroy', 'PLACEHOLDER_ID') }} class="btn btn-danger">Delete</a>';
    deleteLink = deleteLink.replace('PLACEHOLDER_ID', itemId);
    $('.deleteLinkContainer').html(deleteLink);
    $('#confirmationModal').modal('show');
  });

  $('#confirmDelete').click(function() {
    // Perform the delete action here
    // For demonstration purposes, we'll just log a message
    console.log('Item deleted!');
    
    // Close the modal
    $('#confirmationModal').modal('hide');
  });
</script>

@endsection







