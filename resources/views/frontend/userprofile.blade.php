@extends('frontend.master')
@section('title','User Profile Page' )
@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{ asset('usersimages'.'/'.Auth::User()->avatar) }}" alt="Admin" width="150" height="150">
                        <div class="mt-3">
                            <h4>{{ Auth::User()->name }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h3>Personal Details</h3>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ Auth::User()->name }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <h4>{{ Auth::User()->email }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-info "  href="{{ route('userprofile.edit',Auth::user()->id)}}">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

  