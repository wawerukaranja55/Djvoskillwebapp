@extends('backend.adminmaster')
@section('title','Bookings Approved by Manager')
@section('content')
    <div class="container-fluid">
        @if (!empty($bookings))
            <table id="admindatatables" class="table display nowrap" style="width:100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Booking id</th>
                        <th>Clients Full Name</th>
                        <th>Email</th>
                        <th>Booking Status</th>
                        <th>Action</th>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                    
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->full_name }}</td>
                        <td>{{ $booking->bookingtyp->booking_category }}</td>
                        <td>
                            @foreach($booking->bookingstatus as $status)
                                {{ $status->bookingstatus }}
                            @endforeach
                        <td>
                            <a class="btn btn-info" href="{{ route('requestdeposit',$booking->id)}}">View The Booking</a>
                        </td>
                    </tr>
                    @empty
                    <strong style="font-size: 20px;">No Available Bookings</strong>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('#admindatatables').Datatable();
        });
    </script>
@endsection
