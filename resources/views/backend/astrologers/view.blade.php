@extends('backend.layouts.app')
@section('content')

<section class="product-single-items ">
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="row">
                    <div class="col-md-12 cart">
                        <div class="title mt-3">
                            <div class="row">
                                <div class="col">
                                    @include('messages')
                                    <h4><b>Astrologer Detials</b></h4>
                                </div><br>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-2">
                                <p><strong>Name: </strong>{{ $astrologer->name }}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>Gender: </strong>{{ $astrologer->gender }}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>Email: </strong>{{ $astrologer->email }}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>Phone: </strong>{{ $astrologer->mobile_number }}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>Adhar Id: </strong>{{ $astrologer->adhar_id }}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>PAN Id: </strong>{{ $astrologer->pan_number }}</p>
                            </div>


                        </div>


                        <div class="row mt-3">
                            <div class="col-sm-2">
                                <p><strong>Specialization: </strong>{{ $astrologer->specialization }}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>Languaage: </strong>@if(!empty($astrologer->languaage)){{ implode(', ', $astrologer->languaage);  }}@else '-'@endif</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>Address: </strong>{{ $astrologer->address }}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>State: </strong>{{ $astrologer->state }}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>City: </strong>{{ $astrologer->city }}</p>
                            </div>

                            <div class="col-sm-2">
                                <p><strong>Pin Code: </strong>{{ $astrologer->pin_code }}</p>
                            </div>


                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-2">
                                <p><strong>DOB: </strong>{{ $astrologer->date_of_birth ?? 'NA' }}</p>
                            </div>

                            <div class="col-sm-2">
                                <p><strong>Birth Place: </strong>{{ $astrologer->birth_place ?? 'NA'}}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>Experience: </strong>{{ $astrologer->experience ?? 'NA'}}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>Call Charges Per Min: </strong>{{ $astrologer->call_charges_per_min ?? 'NA'}}</p>
                            </div>

                            <div class="col-sm-2">
                                <p><strong>Chat Charges Per Min: </strong>{{ $astrologer->chat_charges_per_min ?? 'NA'}}</p>
                            </div>
                            <div class="col-sm-2">
                                <p><strong>Date Of Joining: </strong>{{ date('j M Y', strtotime($astrologer->created_at))}}</p>
                            </div>


                            <div class="col-sm-2">
                                <p><strong>Certificates: </strong>

                                    @php $files = App\Models\File::where(['type' => 'astro_profile','other_id' => $astrologer->id])->get(); @endphp
                                    @foreach($files as $file)

                                    <span><a href="{{ url(Illuminate\Support\Facades\Storage::url($file->path)) }}"><img height="40px" src="https://w7.pngwing.com/pngs/521/255/png-transparent-computer-icons-data-file-document-file-format-others-thumbnail.png"></a></span>


                                    @endforeach

                                </p>
                            </div>









                        </div>

                        <hr>






                        <h4>Astro Profile Image</h4>
                        <div class="row">
                            @php $images = App\Models\File::where(['type' => 'astro_profile_image','other_id' => $astrologer->id])->get(); @endphp
                            @foreach($images as $image)
                            <div class="col-md-3 mb-3">
                                <span>
                                    <img height="100px" src="{{ url(Illuminate\Support\Facades\Storage::url($image->path)) }}">&nbsp; &nbsp;
                                    <!-- @if($image->status=='0')
                                <a href="{{ route('profileImage.approve', ['id' => $image->id, 'astro_id' =>$astrologer->id ]) }}" class="btn btn-primary">Pending</a>
                            @else 
                                <a href="" class="btn btn-success">Approved</a> 
                            @endif -->

                                   
                                
                                </span>

                            </div>
                            @endforeach

                            <!--  -->
                            <div class="col-md-12 mb-4">
                                <div class="row">
                            <div class="col-md-3">
                             @if($astrologer->profile_status == 'approved' || $astrologer->profile_status == 'rejected')
                                    <div class="btn-group">
                                        @if($astrologer->profile_status == 'approved')
                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Approved
                                        </button>
                                        @elseif($astrologer->profile_status == 'rejected')
                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Rejected
                                        </button>
                                        @endif
                                        
                                        
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.astrologer.active', ['id'=> $astrologer->id, 'status' => 'approved']) }}">Approved</a>
                                            <a class="dropdown-item rejectOption"
                                            data-url="{{ route('admin.astrologer.reject', $astrologer->id) }}">
                                            Rejected
                                        </a>


                                    </div>
                                </div>
                                @if($astrologer->profile_status == 'rejected')
                                <div class="pt-4"><strong>Rejection Remark: </strong>{{ $astrologer->remark; }}</div>
                                @endif
                                @endif
                            </div>
                            </div>
                            </div>
                            <!--  -->
                        </div>















                        <h4>Bank Detials</h4>
                        <hr>
                        @foreach($banks as $bank)
                        @if($bank->status == '1')
                        <table class="table">
                            <tr>
                                <th>Bank Name</th>
                                <th>Account Number</th>
                                <th>IFSC</th>
                            </tr>
                            <tr>
                                <td>{{ $bank->name }}</td>
                                <td>{{ $bank->account_number }}</td>
                                <td>{{ $bank->ifsc }}</td>
                            </tr>


                        </table>

                        @endif

                        <hr>
                        @endforeach






                        <h4>Questions And Answer</h4>


                        <div class="col-lg-12 table-responsive">
                            <table class="table-bordered  invoice-summary table">
                                <thead>
                                    <tr class="bg-trans-dark">
                                        <th data-breakpoints="lg" class="min-col">#</th>
                                        <th width="30%">Question</th>
                                        <th class="text-uppercase">Answer</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php $questions = App\Models\OnboardingAnswer::where('astrologer_id', $astrologer->id)->get(); @endphp
                                    @foreach($questions as $question)



                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $question->question }}
                                        </td>
                                        <td>
                                            {{ $question->answer }}
                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>












                        <div class="row mt-5">
                            <div class="col md-5">

                                <form method="post" action="{{ route('admin.astrologer.commissionPercent', $astrologer->id) }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-from-label" for="purchase_code">Call Charges Per Min</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="call_charges_per_min" placeholder="Call Charges Per Min" value="{{ $astrologer->call_charges_per_min }}" name="call_charges_per_min" class="form-control" autocomplete="off" required>
                                        </div>
                                        @if($errors->has('call_charges_per_min'))
                                        <span class="text-danger">{{ $errors->first('call_charges_per_min') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-from-label" for="purchase_code">Chat Charges Per Min</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="chat_charges_per_min" placeholder="Chat Charges Per Min" value="{{ $astrologer->chat_charges_per_min }}" name="chat_charges_per_min" class="form-control" autocomplete="off" required>
                                        </div>
                                        @if($errors->has('chat_charges_per_min'))
                                        <span class="text-danger">{{ $errors->first('chat_charges_per_min') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-from-label" for="purchase_code">Video Charges Per Min</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="video_charges_per_min" placeholder="Commission Percent" value="{{ $astrologer->video_charges_per_min }}" name="video_charges_per_min" class="form-control" autocomplete="off" required>
                                        </div>
                                        @if($errors->has('video_charges_per_min'))
                                        <span class="text-danger">{{ $errors->first('video_charges_per_min') }}</span>
                                        @endif
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-3 col-from-label" for="purchase_code">Commission Percent</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="commission_percent" placeholder="Commission Percent" value="{{ $astrologer->commission_percent }}" name="commission_percent" class="form-control" autocomplete="off">
                                        </div>
                                        @if($errors->has('commission_percent'))
                                        <span class="text-danger">{{ $errors->first('commission_percent') }}</span>
                                        @endif
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-3 col-from-label" for="purchase_code">Score</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="score" placeholder="Score" value="{{ $astrologer->score }}" name="score" class="form-control" autocomplete="off">
                                        </div>
                                        @if($errors->has('score'))
                                        <span class="text-danger">{{ $errors->first('score') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-from-label" for="purchase_code">Commission Descreption</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="commission_descreption" placeholder="Commission Descreption" value="{{ $astrologer->commission_descreption }}" name="commission_descreption" class="form-control" autocomplete="off">
                                        </div>
                                        @if($errors->has('commission_descreption'))
                                        <span class="text-danger">{{ $errors->first('commission_descreption') }}</span>
                                        @endif
                                    </div>


                                    <div class="form-group mb-0 text-right">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>

                                </form>

                            </div>

                        </div>















                    </div>

                </div>

            </div>

        </div>
    </div>

</section>

<!-- Table -->
<section class="misscall-table-sections">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Call Logs</h4>
        </div>
        <div class="card-body">
            <div class="table-responsivee">
                <table class="table table-bordered" id="misscalls-datatable">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>User Name</td>
                            <td>Status</td>
                            <td>Time</td>
                            <td>Date</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($missCallLogs ?? [] as $missCallLog)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="#">{{ $missCallLog->user->name }}</a></td>
                            <td>
                                @php
                                $status = strtolower($missCallLog->status);
                                $colors = [
                                'accept' => 'text-success',
                                'misscall' => 'text-danger',
                                'cancel' => 'text-secondary',
                                'reject' => 'text-warning',
                                ];
                                $colorClass = $colors[$status] ?? 'text-black bg-gray-50';
                                @endphp

                                <span class="px-2 py-1 rounded {{ $colorClass }}">
                                    {{ str()->title($status) }}
                                </span>
                            </td>
                            <td>{{ $missCallLog->created_at->format('h:i:s A') }}</td>
                            <td>{{ $missCallLog->created_at->format('F d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- End Table-->

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

<script>
    $(document).ready(function() {
        new DataTable('#misscalls-datatable');
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