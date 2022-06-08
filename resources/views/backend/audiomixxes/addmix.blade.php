
@extends('backend.adminmaster')
@section('title','Add A Mixtape')
@section('content')
<div class="container" style="border:2px solid black; background:rgb(255, 249, 249);">
    <h2>Add A New Audio Mix</h2>
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
        <form method="post" id="mixupload" action="{{ route('mixxes.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Audio Mix Name</label>
                <input type="text" class="form-control {{ $errors->has('mix_name') ? 'error' : '' }}" name="mix_name" id="mix_name">
                <!-- Error -->
                @if ($errors->has('mix_name'))
                <div class="error">
                    {{ $errors->first('mix_name') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label>Audio Mix Length</label>
                <input type="number" class="form-control {{ $errors->has('mix_length') ? 'error' : '' }}" name="mix_length" id="mix_length">
                <!-- Error -->
                @if ($errors->has('mix_length'))
                <div class="error">
                    {{ $errors->first('mix_length') }}
                </div>
                @endif
            </div>

            <div class="form-group">
                <label>Audio Mix Size</label>
                <input type="number" class="form-control {{ $errors->has('mix_size') ? 'error' : '' }}" name="mix_size"
                    id="mix_size">

                @if ($errors->has('mix_size'))
                <div class="error">
                    {{ $errors->first('mix_size') }}
                </div>
                @endif
            </div>

            <!-- Main Image Button--->
            <label for="file">Audio-Mix-Image</label>
            <input type="file" name="mix_image" onchange="readURL(this);"/>
            <img id="mix_image" style="width: 100px;"  src="{{asset('dist/admin/productimages')}}"/>
            <br>

            <!-- Audio Mix--->
            <label for="mix_audio" class="form-label">Audio Mix File</label>
            <input class="form-control form-control-lg" id="mixaudio" type="file" name="mix_audio" onchange="readURL(this);"/>
            
            <br>

            {{-- <div class='progress' id="progressDivId">
                <div class='progress-bar' id='progressBar'></div>
                <div class='percent' id='percent'>0%</div>
            </div>
            <div style="height: 10px; font-color:white;"></div>
            <div id='outputImage'></div> --}}

            <button type="submit" class="btn btn-dark btn-block">Submit</button>
        </form>
    </div>
</div>


@endsection