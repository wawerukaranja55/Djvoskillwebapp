@extends('frontend.master')
@section('title','update user profile' )
@section('content')
<div class="container">
    @if($errors)
            @foreach($errors->all() as $error)
            <p class="text-danger">{{$error}}</p>
            @endforeach
@endif
    <form method="post" action="{{ url('userprofile/'.Auth::User()->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        {{-- <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ Auth::User()->username }}">
        </div> --}}
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::User()->name }}">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" id="email" name="email" value="{{ Auth::User()->email }}">
        </div>
        <div>
            <label for="file">My Profile Photo</label>
            <input type="file" name="avatar" value="{{ $user->avatar }}"/>
            <img id="avatar" style="width: 100px;"  src="{{ asset('usersimages/'.Auth::User()->avatar) }}"/>
        </div>
    
        <button type="submit" class="btn btn-dark btn-block">Submit</button>
    </form>
</div>
@endsection
