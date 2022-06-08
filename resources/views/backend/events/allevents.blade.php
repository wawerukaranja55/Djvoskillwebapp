@extends('backend.adminmaster')
@section('title','All Events')
@section('content')
<div class="container">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('events.create') }}">Add An Event</a>
        </div>
    </div>
    @if (!empty($events))
    <table id="admindatatables" class="table table-striped table-bordered dt-responsive nowrap  order-column" style="width:100%">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                @if ($message=Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
            </div>
        </div>
        <thead class="thead-dark">
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
</div>
    
@endif
@endsection
