@extends('backend.adminmaster')
@section('title','All Events')
@section('content')
<div class="container" style="border: 2px solid black;">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            @if ($message=Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('adminevents.create') }}">Add An Event</a>
        </div>
    </div>
    @if (!empty($events))
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Event Name</th>
                <th scope="col">Event Location</th>
                <th scope="col">Event Details</th>
                <th scope="col">Event Time</th>
                <th scope="col">Event Flyer</th>
                <th scope="col">Action</th>
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
                <td><img src="{{ asset ('eventimages/'.$event->eve_image) }}" style="width:120px; border:2px solid black;height:80px;"></td>
                <td>
                    <form action="{{route('adminevents.destroy',$event->id)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <a class="btn btn-warning" href="{{ route('adminevents.show',$event->id)}}"> Show </a>
                        <a class="btn btn-danger" href="{{ route('adminevents.edit',$event->id)}}"> Edit </a>
                        <input type="submit" class="btn btn-success mt-2" value="DELETE">
                    </form>
                </td>
            </tr>
            @empty
            <strong style="font-size: 20px;">No Available Products</strong>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {!! $events->links() !!}
    </div>
</div>
    
@endif
@endsection
