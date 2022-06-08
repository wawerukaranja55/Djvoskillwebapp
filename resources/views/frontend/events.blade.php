
@extends('frontend.master')
@section('title','Voskill Events')
@section('content')

<!-- START SCHEDULE -->
<section id="schedule" class="section-padding" style="border: 2px solid black;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <h3>Event Schedule</h3>
                    <span></span>
                    <p>This are all our upcoming Events and Tv shows</p>
                </div>
            </div>
            <!-- end col -->
            <div class="container">
                @if (count($events)>0)
                            @foreach ($events as $eve)
                            <div class="schedule-single">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                                        <img class="rounded  img-fluid" src="{{ asset('eventimages/'.$eve->eve_image) }}" alt="{{ $eve->eve_name }}">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="schedule-single-info">
                                            <h4>{{ $eve->eve_name }}</h4>
                                            <p>{{ $eve->eve_details }}</p>
                                            <span class="post-date"><i class="far fa-clock"></i>{{ $eve->eve_date}}</span>
                                            <span class="post-comment"><i class="fas fa-compass"></i>{{ $eve->eve_location }}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="border: 2px solid green">
                                        <a href="#" class="schedule-btn">Purchase Ticket</a>
                                        <a href="{{ url('event/'.Str::slug($eve->eve_name).'/'.$eve->id) }}" class="schedule-btn">View Details</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                             <h3>No Events has been Found</h3>
                            @endif
                            <div class="d-flex justify-content-center">
                                {!! $events->links() !!}
                            </div>
            </div>
        </div>
        <!--- END ROW -->
    </div>
    <!--- END CONTAINER -->
</section>
<!-- END SCHEDULE -->

@endsection