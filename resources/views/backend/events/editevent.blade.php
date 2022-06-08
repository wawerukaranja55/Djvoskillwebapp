
@extends('backend.adminmaster')
@section('title','Edit Event Details')
@section('content')
<div class="container" style="border:2px solid black; background:rgb(255, 249, 249);">
    <h2>Edit The Event Details</h2>
        <div class="container mt-5">
            <!-- Success message -->
            @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <strong>Please Check The Details Again</strong>
                <ul>
                    @foreach ($errors ->all() as $error)
                       <li>{{ $error }}</li> 
                    @endforeach
                </ul>
            @endif
            <form method="POST" action="{{ route('events.update',$event->id) }}" enctype="multipart/form-data">
                
                {{ csrf_field() }}
                @method('PATCH') 

                <div class="form-group">
                    <label>Event Name</label>
                    <input type="text" class="form-control {{ $errors->has('eve_name') ? 'error' : '' }}" name="eve_name" id="eve_name" value="{{ old('eve_name') ?? $event->eve_name }}">
                    <!-- Error -->
                    @if ($errors->has('eve_name'))
                    <div class="error">
                        {{ $errors->first('eve_name') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Event Location</label>
                    <input type="text" class="form-control {{ $errors->has('eve_location') ? 'error' : '' }}" name="eve_location" id="eve_location" value="{{ old('eve_location') ?? $event->eve_location }}">
                    <!-- Error -->
                    @if ($errors->has('eve_location'))
                    <div class="error">
                        {{ $errors->first('eve_location') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Event Time</label>
                    <input type="text" class="form-control {{ $errors->has('eve_time') ? 'error' : '' }}" name="eve_time" id="eve_time" value="{{ old('eve_time') ?? $event->eve_time }}"
                        id="eve_time">
    
                    @if ($errors->has('eve_time'))
                    <div class="error">
                        {{ $errors->first('eve_time') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Event Date</label>
                    <input type="text" class="form-control {{ $errors->has('eve_date') ? 'error' : '' }}" name="eve_date" id="eve_date" value="{{ old('eve_date') ?? $event->eve_date }}"
                        id="eve_date">
    
                    @if ($errors->has('eve_date'))
                    <div class="error">
                        {{ $errors->first('eve_date') }}
                    </div>
                    @endif
                </div>

    
                <div class="form-group">
                    <label>Event Details</label>
                    <input type="text" class="form-control {{ $errors->has('eve_details') ? 'error' : '' }}" name="eve_details" id="eve_details" value="{{ old('eve_details') ?? $event->eve_details }}">
    
                    @if ($errors->has('eve_details'))
                    <div class="error">
                        {{ $errors->first('eve_details') }}
                    </div>
                    @endif
                </div>
                <br>
                <!-- Main Image Button--->
                @if ($event->eve_image)
                   <img src="{{ asset ('eventimages/'.$event->eve_image) }}" style="width:120px; border:2px solid black;height:80px;"> 
                @endif
                <label for="file">Change Event Image</label>
                <input type="file" name="eve_image" onchange="readURL(this);" value="{{ $event->eve_image }}"/>
                <img id="eve_image" style="width: 100px;"  src="{{asset('dist/admin/eventimages')}}"/>
                <br>

                <button type="submit" class="btn btn-dark btn-block">Update </button>
            </form>
        </div>
</div>
@endsection