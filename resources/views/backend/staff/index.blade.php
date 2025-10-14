@extends('backend.layouts.app')

@section('content')

<div class="tab-content">
    <div class="tab-pane fade in active show" id="installed">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    @include('messages')
                    <div class="headingBtn">
                        <h2>Staffs</h2>
                        <a class="btn btn-info" href="{{ route('admin.staff.create') }}">ADD NEW</a>
                    </div>


                    <!--table start-->
                    <table id="example" class="display" style="width:100%">
                        <thead class="bg-light">
                            <tr>
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Role</th>
                                <th>Active/Inactive</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staffs as $staff)

                            @php
                            $roleName = [];
                            @endphp
                            @foreach ($staff->roles as $role)
                            @php $roleName[] = $role->name; @endphp
                            @endforeach
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $staff->name }}</td>
                                <td>{{ $staff->email }}</td>
                                <td>{{ $staff->mobile_number }}</td>
                                <td>{{ implode(",",$roleName) }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if($staff->status == 1)

                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Active
                                        </button>

                                        @else

                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            In-Active
                                        </button>
                                        @endif

                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.staff.active', $staff->id) }}">Active</a>
                                            <a class="dropdown-item" href="{{ route('admin.staff.deActive', $staff->id) }}">In-Active</a>

                                        </div>

                                </td>
                                <td style="font-size: 18px;">
                                    <a href="{{ route('admin.staff.edit', $staff->id) }}" class="btn btn-success">Edit</a>
                                    <!-- <a href ="{{ route('admin.staff.destroy', $staff->id) }}" class="btn btn-danger">Delete</a> -->
                                    <a href="#" class="btn btn-danger deleteButton" data-item-id="{{ $staff->id }}"><i class="fa fa-trash" aria-hidden="true"></i>
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
                                <th>Active/Inactive</th>
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
    $(document).ready(function() {
        new DataTable('#example');
    });

    $('.deleteButton').click(function() {
        var itemId = $(this).data('item-id');


        let route = "{{ route('admin.staff.destroy', 'PLACEHOLDER_ID') }}";
        var deleteLink = '<a href="' + route + '">Delete</a>';
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