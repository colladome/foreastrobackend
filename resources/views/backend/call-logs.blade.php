@extends('backend.layouts.app')
@section('content')
<div class="row">
   <div class="col-lg-12">
       
<!-- Table -->
<section class="misscall-table-sections">
    <div class="card">
    <div class="card-header">
        <h4 class="mb-0">Call Logs</h4>  
    </div>
    <div class="card-body">       
    
    <div class="filter-wrapper">       
        <form method="GET" action="{{ url()->current() }}" class="row g-2 mb-3">
            <!-- From Date -->
            <div class="col-md-3">
                <input type="date" name="from" class="form-control" 
                       placeholder="From date" value="{{ request('from', date('Y-m-d')) }}" required>
            </div>
        
            <!-- To Date -->
            <div class="col-md-3">
                <input type="date" name="to" class="form-control" 
                        placeholder="To date" value="{{ request('to', date('Y-m-d')) }}" required>
            </div>
        
            <!-- Apply Button -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Apply</button>
            </div>
        </form>
    </div>
    
    <div class="table-responsivee">
        <table class="table table-bordered" id="call-logs-datatable">
            <thead>
                <tr>
                    <td>#</td>
                    <td>User Name</td>
                    <td>User Email</td>
                    <td>User Mobile</td>
                    <td>Astrologer Name</td>
                    <td>Status</td>
                    <td>Time</td>
                    <td>Date</td>
                </tr>
            </thead>
            <tbody>
                @foreach($callLogs ?? [] as $callLog)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><a href="#">{{ $callLog->user->name }}</a></td>
                    <td><a href="#">{{ $callLog->user->email }}</a></td>
                    <td><a href="#">{{ $callLog->user->mobile_number }}</a></td>
                    <td><a href="#"><a href="{{ url('admin/astrologer-view/'.$callLog->astrologer->id) }}">{{ $callLog->astrologer->name }}</a></td>
                    <td>
                        @php
                            $status = strtolower($callLog->status);
                            $colors = [
                                'accept'   => 'text-success',
                                'misscall' => 'text-danger',
                                'cancel'   => 'text-secondary',
                                'reject'   => 'text-warning',
                            ];
                            $colorClass = $colors[$status] ?? 'text-black bg-gray-50';
                        @endphp
                        
                        <span class="px-2 py-1 rounded {{ $colorClass }}">
                            {{ str()->title($status) }}
                        </span>
                    </td>
                    <td>{{ $callLog->created_at->format('h:i:s A') }}</td>
                    <td>{{ $callLog->created_at->format('F d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
</section>
<!-- End Table-->

    </div>
<div>
    
    <script>
      $(document).ready(function() {
        new DataTable('#call-logs-datatable');
    });
</script>
@endsection

    
       