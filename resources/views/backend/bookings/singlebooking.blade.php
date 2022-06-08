@extends('backend.adminmaster')
@section('title','Show A Booking')
@section('content')
    <div class="content-wrapper">
        <h1 style="text-align: center"> Booking Details</h1>
        
        <button class="btn btn-warning float-right">
            <a href="#">Bookings Pending Approval</a>
        </button>
        
        <h2 class="ml-3"> {{ $booking->id }}.{{ $booking->full_name }}</h2>

        <!-- Success message -->
        @if(Session::has('success'))
           <p class="text-success">{{session('success')}}</p>
        @endif

        <form method="post" action="{{  route('changestatus',$booking->id)  }}">
            @csrf
            {{-- @method('PUT') --}}
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="full_name" class="form-control disabled" readonly="" value="{{ $booking->full_name }}" id="name">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control disabled" readonly="" value="{{ $booking->email }}" id="email">
            </div> 
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" class="form-control disabled" readonly="" value="{{ $booking->location }}" id="location">
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="text" name="date" class="form-control disabled" readonly="" value="{{ $booking->date }}" id="date">
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control disabled" readonly="" value="{{ $booking->phone }}" id="phone">
            </div>
            <div class="form-group">
                <label>Event Type</label>
                <select name="eventcategory" class="form-control" id="FormControlSelect">
                    @foreach($bookingcats as $bookingcat)
                        @if ($bookingcat->id==$booking->event_id)
                            <option type="text" readonly="" selected value="{{ $bookingcat->id }}">{{ $bookingcat->booking_category }}</option>
                        @endif
                    @endforeach
                </select>

                <input type="hidden" name="is_booking" class="form-control disabled" readonly="" value="0">
                {{-- <input type="text" name="eventcategory" class="form-control disabled" readonly="" value="{{ $booking->bookingtyp->booking_category }}" id="eventtype"> --}}
            </div>
            <div class="form-group">
                <label>Event Details</label>
                <textarea id="event_details" name="event_details" readonly="" class="form-control">
                    {{ $booking->event_details }}
                </textarea>
            </div>

            <button class="btn btn-dark" type="submit">
                @if($booking->is_booking==0)
                Approve to Accountant
                @else
                Unapprove The Booking
                @endif
            </button>
            <button class="btn btn-warning">
                <a href="#">Bookings Pending Approval</a>
            </button>
        </form>
    </div>
    
@endsection
