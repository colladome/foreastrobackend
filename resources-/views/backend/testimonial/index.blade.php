@extends('backend.layouts.app')

@section('content')

<div class="tab-content">
    <div class="tab-pane fade in active show" id="installed">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    @include('messages')
                    <div class="headingBtn">
                        <h4>Testimonials</h4>
                        <a class="btn btn-info" href="{{ route('admin.testimonial.create') }}">ADD NEW</a>
                    </div>

                    <table class="table" id="testimonial" width="100%">
                        <thead>
                            <tr class="gry-color" style="background: #eceff4;">
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Rating</th>
                                <th>Discretion</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody class="strong">
                            @foreach ($testimonials as $testimonial)

                            <tr class="">

                                <td scope="row">{{ $loop->iteration }}</td>
                                <td class="">{{ $testimonial->name}}</td>
                                <td class=""><img src="{{  asset('storage/' . $testimonial->image) }}" height="100 px;" width="150 px;"></td>
                                <td class="">{{ $testimonial->rating}}</td>
                                <td class="">{{ $testimonial->descreption}}</td>

                                <td class="">

                                    <a href="{{ route('admin.testimonial.edit', $testimonial->id) }}" class="btn btn-success">Edit</a>


                                    <a href="#" class="btn btn-danger deleteButton" data-item-id="{{ $testimonial->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>

                                </td>



                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                    <!-- end table-->





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
        new DataTable('#testimonial');
    });

    // jQuery to show the confirmation modal and handle delete action
    $('.deleteButton').click(function() {
        var itemId = $(this).data('item-id');
        let route = "{{ route('admin.testimonial.delete', 'PLACEHOLDER_ID') }}";
        var deleteLink = '<a href="' + route + '">Delete</a>';
        deleteLink = deleteLink.replace('PLACEHOLDER_ID', itemId);
        $('.deleteLinkContainer').html(deleteLink);
        $('#confirmationModal').modal('show');
    });

    $('#confirmDelete').click(function() {

        $('#confirmationModal').modal('hide');
    });
</script>

@endsection