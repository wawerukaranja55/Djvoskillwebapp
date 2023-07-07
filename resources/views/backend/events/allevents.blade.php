@extends('backend.adminmaster')
@section('title','All Events')
@section('content')

<div class="container">
    <div class="row shadow mb-5 bg-black rounded">
      <div class="row">
          <div class="col-lg-12 margin-tb">
              <div class="pull-right">
                <a class="btn btn-success" href="{{ route('events.create') }}">Add An Event</a>
              </div>
          </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
            <div class="panel-heading mt-5" style="text-align: center;"> 
                <h3 class="mb-2 panel-title">All Merchadises</h3> 
            </div>
            <table id="products" class="table table-striped table-bordered nowrap" style="width:100%; border:2px solid black;">
                <thead>
                    <tr>
                      <th>id</th>
                      <th>Event Name</th>
                      <th>Event Location</th>
                      {{-- <th>Event Details</th> --}}
                      <th>Event Time</th>
                      <th>Event Date</th>
                      <th>Event Flyer</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr>
                      <td>{{$event->id}}</td>
                      <td>{{$event->eve_name}}</td>
                      <td>{!!str_limit($event->eve_location,10)!!}</td>
                      {{-- <td>{!!str_limit($event->eve_details,15)!!}</td> --}}
                      <td>{{$event->eve_time}}</td>
                      <td>{{$event->eve_date}}</td>
                      <td><img src="{{ asset ('eventimages/'.$event->eve_image) }}" style="width:80px; border:2px solid black;height:80px;"></td>
                      <td>
                        <a class="btn btn-primary btn-xs" title="Edit the Event Details" href="{{ route('events.edit',$event->id)}}"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-primary btn-xs" title="Delete the Event Details" onclick="confirm return('Are you Sure You want to Delete?')" href="{{ url('admin/events/'.$event->id.'/delete')}}"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
      </div>
    </div>
</div>








{{-- <div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('events.create') }}">Add An Event</a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            @if (!empty($events))
            <table id="products" class="table table-striped table-bordered nowrap" style="width:100%; border:2px solid black;">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Event Name</th>
                        <th>Event Location</th>
                        <th>Event Details</th>
                        <th>Event Time</th>
                        <th>Event Date</th>
                        <th>Event Flyer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr>
                        <td>{{$event->id}}</td>
                        <td>{{$event->eve_name}}</td>
                        <td>{{$event->eve_location}}</td>
                        <td>{{$event->eve_details}}</td>
                        <td>{{$event->eve_time}}</td>
                        <td>{{$event->eve_date}}</td>
                        <td><img src="{{ asset ('eventimages/'.$event->eve_image) }}" style="width:120px; border:2px solid black;height:80px;"></td>
                        <td>
                            <form action="{{route('events.destroy',$event->id)}}" method="post">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <a class="btn" href="{{ route('events.show',$event->id)}}"> Show </a>
                                <a class="btn" href="{{ route('events.edit',$event->id)}}"> Edit </a>
                                <input type="submit" class="btn" value="DELETE">
                            </form>
                        </td>
                    </tr>
                    @empty
                    <strong style="font-size: 20px;">No Event has been Added</strong>
                    @endforelse
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div> --}}
@endsection
