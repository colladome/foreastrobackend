@extends('backend.layouts.app')
@section('content')
<div class="tab-content">
    <div class="tab-pane fade in active show" id="installed">
        <div class="row container">
            <div class="col-lg-11 mx-auto">

                <div class="card">
                    <h4>User Inquiries</h4>
                    @include('messages')

                    <table id="banner">
                        <thead>
                            <tr class="gry-color">
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Number Of Room</th>
                                <th>Number Of guest</th>
                                <th>Dates</th>
                                <th>Function Type</th>
                                <th>Function Time</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody class="strong ">
                            @foreach ($inquires as $inquiry)

                            <tr class="">

                                <td scope="row">{{ $loop->iteration }}</td>
                                <td class="">{{ $inquiry->name}}</td>
                                <td class="">{{ $inquiry->email}}</td>
                                <td class="">{{ $inquiry->number_of_room}}</td>
                                <td class="">{{ $inquiry->number_of_guest}}</td>
                                <td class="">{{implode(",",$inquiry->booking_date) }}</td>
                                <td class="">{{ $inquiry->function_type}}</td>
                                <td class="">{{ $inquiry->function_time}}</td>
                                <td class="">



                                    <!-- Example single danger button -->
                                    <div class="btn-group">
                                        @if($inquiry->status == '1')

                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Completed
                                        </button>

                                        @else

                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Pending
                                        </button>
                                        @endif

                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.changeInquiryStatusActive', $inquiry->id) }}">Completed</a>
                                            <a class="dropdown-item" href="{{ route('admin.changeInquiryStatusInActive', $inquiry->id) }}">Pending</a>

                                        </div>
                                </td>



                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                    <!-- end table-->










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
    $('#banner').DataTable({
        responsive: true,
        scrollX: true
    });
</script>


@endsection