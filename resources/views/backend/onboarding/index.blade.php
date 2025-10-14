@extends('backend.layouts.app')

@section('content')

<div class="tab-content">
    <div class="tab-pane fade in active show" id="installed">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    @include('messages')
                    <div class="headingBtn">
                        <h2>Onboarding Questions</h2>
                        <a class="btn btn-info" href="{{ route('admin.question.create') }}">ADD</a>
                    </div>


                    <!--table start-->
                    <table id="blog" class="display" style="width:100%">
                        <thead class="bg-light">
                            <tr>
                                <th>S.N</th>
                                <th>Question</th>
                                <th>Type</th>
                                <th>Active/In-Active</th>
                                <th>Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($onboardingQuestions as $onboardingQuestion)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $onboardingQuestion->question }}</td>
                                <td>{{ $onboardingQuestion->type }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if($onboardingQuestion->status == 1)

                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Active
                                        </button>

                                        @else

                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            In-Active
                                        </button>
                                        @endif

                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.question.active', $onboardingQuestion->id) }}">Active</a>
                                            <a class="dropdown-item" href="{{ route('admin.question.inActive', $onboardingQuestion->id) }}">In-Active</a>

                                        </div>

                                    </div>
                                </td>



                                <td>
                                    <a href="{{ route('admin.question.edit', $onboardingQuestion->id) }}" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </i></a>
                                    <a href="#" class="btn btn-danger deleteButton" id="deleteButton" data-item-id="{{ $onboardingQuestion->id }}"><i class="fa fa-trash" aria-hidden="true"></i>

                                    </a>
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S.N</th>
                                <th>Question</th>
                                <th>Type</th>
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
        new DataTable('#blog');
    });





    // jQuery to show the confirmation modal and handle delete action
    $('.deleteButton').click(function() {
        var itemId = $(this).data('item-id');
        let route = "{{ route('admin.question.delete', 'PLACEHOLDER_ID') }}";
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