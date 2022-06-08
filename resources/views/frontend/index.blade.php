
@extends('frontend.master')
@section('title','VOSKILL')
@section('content')
    <!----Events Start---->
    <div class="ms_genres_wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="ms_heading">
                    <h2>Upcoming Events</h2>
                    <span class="veiw_all"><a href="{{route ('events') }}">View All</a></span>
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
                            <a href="#">Buy tickets</a>
                        </button>
                        <button type="button" class="btn-success" style="hover{background:blue;}">
                            <a href="{{ url('event/'.Str::slug($event->eve_name).'/'.$event->id) }}">More Details</a>
                        </button>
                    </div><!--\\event-feed latest-->
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
    
    <!----Blog Start---->
    <div class="ms_genres_wrapper" style=" margin-bottom:20px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="ms_heading">
                    <h2>Blog Posts</h2>
                    <span class="veiw_all"><a href="{{route ('blog') }}">View All</a></span>
                </div>
            </div>
            @foreach ($blog as $bl )
            <div class="col-lg-3 col-md-6" style="border:2px solid black;">
                <div class="swiper-slide">
                    <div class="ms_rcnt_box">
                        <div class="ms_rcnt_box_img">
                            <img src="{{ asset('blogposts/'.$bl->blo_image) }}" alt="{{ $bl->blo_title }}" style="width:100%; height:200px;">
                            
                        </div>
                        <div class="ms_rcnt_box_text">
                            <h3><a href="{{ url('blog/post/'.Str::slug($bl->blo_title).'/'.$bl->id) }}">{{ $bl->blo_title }} </a></h3>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>

    <!----Mixtapes Start---->
    <div class="ms_genres_wrapper" style=" margin-bottom:20px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="ms_heading">
                    <h2>Mixtapes</h2>
                    <span class="veiw_all"><a href="{{route ('audiomixtapes') }}">View All</a></span>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                
                @if (!empty($mixxes))
                    <table id="frontendmix" class="table table-bordered  display nowrap" cellspacing="0" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Stream</th>
                                <th>Size</th>
                                <th>Download</th>
                        </thead>
                        <tbody>
                            @forelse ($mixxes as $mix)
                            
                            <tr>
                                <td>{{ $mix->mix_name }}</td>
                                <td><img src="{{ asset ('miximages/'.$mix->mix_image) }}" class="img-fluid" style="width:120px; height:120px;"></td>
                                <td>
                                    <div class="players" style="border: 2px solid black; margin:0;">
                                        <audio id="player2" preload="none" controls >
                                            <source src="{{ asset ('mixtapes/'.$mix->mix_audio) }}" type="audio/mp3">                
                                        </audio>
                                    </div>
                                </td>
                                <td>{{$mix->mix_size}}Mb</td>
                                <td><a href="/home/download/{{$mix->mix_audio}}">Download</a></td>
                            </tr>
                            @empty
                            <strong style="font-size: 20px;">No Available Mixxes</strong>
                            @endforelse
                        </tbody>
                        <tfoot class="thead-dark">
                            <th>Name</th>
                            <th>Image</th>
                            <th>Stream</th>
                            <th>Size</th>
                            <th>Download</th>
                        </tfoot>
                    </table>
                @endif
            </div>
            
        </div>
    </div>

    <!----Products start---->
    <div class="ms_genres_wrapper" style=" margin-bottom:20px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="ms_heading">
                    <h2>Our Merchadise</h2>
                    <span class="veiw_all"><a href="{{route ('blog') }}">View All</a></span>
                </div>
            </div>
            @foreach ($merchad as $merch )
            <div class="col-lg-3 col-md-6" style="border:2px solid black;">
                <div class="swiper-slide">
                    <div class="ms_rcnt_box">
                        <div class="ms_rcnt_box_img">
                            <img src="{{ asset('blogposts/'.$merch->blo_image) }}" alt="{{ $merch->blo_title }}" style="width:100%; height:200px;">
                            
                        </div>
                        <div class="ms_rcnt_box_text">
                            <h3><a href="{{ url('blog/post/'.Str::slug($merch->blo_title).'/'.$merch->id) }}">{{ $merch->blo_title }} </a></h3>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
@endsection