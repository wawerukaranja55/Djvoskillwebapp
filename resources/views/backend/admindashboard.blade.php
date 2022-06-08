@extends('backend.adminmaster')
@section('title','Admin Dashboard')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-end flex-wrap">
                        <div class="mr-md-3 mr-xl-5">
                            <h2>Welcome <strong style="text-transform: uppercase;">{{ Auth::user()->name }}</strong></h2>
                        </div>
                        <div class="d-flex">
                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body dashboard-tabs p-0">
                        <ul class="nav nav-tabs px-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Website Analytics</a>
                            </li>
                        </ul>
                        <div class="tab-content py-0 px-0">
                            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                <div class="d-flex flex-wrap justify-content-xl-between">
                                    <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="mdi mdi-account-box mr-3 icon-lg text-danger"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted">Registered Users</small>
                                        <h5 class="mr-2 mb-0">{{ count($user) }}</h5>
                                        </div>
                                    </div>
                                    <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="mdi mdi-blogger mr-3 icon-lg text-danger"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted">Posts</small>
                                        <h5 class="mr-2 mb-0">{{ count($posts) }}</h5>
                                        </div>
                                    </div>
                                    <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="mdi mdi-music mr-3 icon-lg text-success"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted">Mixtapes</small>
                                        <h5 class="mr-2 mb-0">{{ count($mixxes) }}</h5>
                                        </div>
                                    </div>
                                    <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <a href="#">
                                            <i class="mdi mdi-calendar-clock mr-3 icon-lg text-warning"></i>
                                            <div class="d-flex flex-column justify-content-around">
                                            <small class="mb-1 text-muted">Events</small>
                                            <h5 class="mr-2 mb-0">{{ count($events) }}</h5>
                                        </a>
                                    </div>
                                    </div>
                                    <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="mdi mdi-calendar-clock mr-3 icon-lg text-warning"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted">Merchadise</small>
                                        <h5 class="mr-2 mb-0">{{ count($merchadise) }}</h5>
                                        </div>
                                    </div>
                                    <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                        <i class="mdi mdi-calendar-clock mr-3 icon-lg text-warning"></i>
                                        <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted">Bookings</small>
                                        <h5 class="mr-2 mb-0">{{ count($bookings) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!----Events Start---->
        <div class="ms_genres_wrapper" style=" margin-bottom:20px;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ms_heading">
                        <h3>Upcoming Events</h3>
                        <span class="veiw_all"><a href="{{route ('events.index') }}">View All</a></span>
                    </div>
                </div>
                @foreach ($events as $event )
                <div class="col-lg-3 col-md-6">
                    <div class="swiper-slide">
                        <div class="event-feed latest" style="border: 1px solid;
                        padding: 5px;
                        box-shadow: 5px 5px 5px 5px #888888;">
                            <img src="{{asset('eventimages/'.$event->eve_image) }}"  alt="" style="width:100%; height:200px;">
                            
                            <h5><a href="{{ route('events') }}" >{{ $event->eve_name }}</a></h5>
                            <ul style="list-style-type: none;">
                                <li><i class=" fa fa-location-arrow"></i>{{ $event->eve_location }}</li>
                                <li><i class="fas fa-clock"></i></b>{{ $event->eve_time }}</li>
                                
                            </ul>
                            <button type="button" class="btn-default">
                                <a href="{{ route('events.edit',$event->id)}}">Update Event</a>
                            </button>
                            <button type="button" class="btn-warning">
                                <a href="{{ route('events.show',$event->id)}}">Show Event</a>
                            </button>
                        </div><!--\\event-feed latest-->
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>

        <!----Events Start---->
        <div class="ms_genres_wrapper" style=" margin-bottom:20px;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ms_heading">
                        <h3>Blog Posts</h3>
                        <span class="veiw_all"><a href="{{route ('blogpost.index') }}">View All</a></span>
                    </div>
                </div>
                @foreach ($adminposts as $post )
                <div class="col-lg-3 col-md-6">
                    <div class="swiper-slide">
                        <div class="event-feed latest" style="border: 1px solid;
                        padding: 5px;
                        box-shadow: 5px 5px 5px 5px #888888;">
                            <img src="{{ asset ('blogposts/'.$post->blo_image) }}"  alt="" style="width:100%; height:200px;">
                            
                            <h5>{{$post->blo_title}}</h5>
                        
                            <button type="button" class="btn-default">
                                <a href="{{ url('admin/blogpost/'.$post->id.'/edit')}}">Update Post</a>
                            </button>
                        </div><!--\\event-feed latest-->
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </div>
@endsection