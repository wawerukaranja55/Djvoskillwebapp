@extends('backend.adminmaster')
@section('title','List Audio Mixtapes')
@section('content')
<div class="container">
    <div class="row" style="border: 2px solid yellow">
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
                <a class="btn btn-success" href="{{ route('mixxes.create') }}">Add A Mixtape</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            @if (!empty($mixxes))
            <table class="table table-bordered mt-5 dt-responsive nowrap  order-column" id="admindatatables" style="border:2px solid red;">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Mixtape Name</th>
                        <th scope="col">Mixtape Length</th>
                        <th scope="col">Mixtape Size</th>
                        <th scope="col">Mixtape Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mixxes as $mix)
                    <tr>
                        <td>{{$mix->id}}</td>
                        <td>{{$mix->mix_name}}</td>
                        <td>{{$mix->mix_length}}mins</td>
                        <td>{{$mix->mix_size}}MB</td>
                        <td><img src="{{ asset ('miximages/'.$mix->mix_image) }}" style="width:120px; border:2px solid black;height:80px;"></td>
                        <td>
                            <form action="{{route('mixxes.destroy',$mix->id)}}" method="post">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <a class="btn btn-success" href="{{ route('mixxes.edit',$mix->id)}}"> Edit </a>
                                <input type="submit" class="btn btn-warning" value="DELETE">
                            </form>
                        </td>
                    </tr>
                    @empty
                    <strong style="font-size: 20px;">No Available Mixxes</strong>
                    @endforelse
                </tbody>
            </table>
            {{-- <div class="d-flex justify-content-center">
                {!! $mixxes->links() !!}
            </div> --}}
            @endif
        </div>
    </div>
    
</div>
@endsection
