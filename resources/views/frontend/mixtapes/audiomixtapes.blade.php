   
@extends('frontend.master')
@section('title','Audio Mixtapes')
@section('content')
<div class="row">
    <div class="col-md-12">
      <H2 class="text-center">Mixtapes</H2>
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
                    <td><img src="{{ asset ('miximages/'.$mix->mix_image) }}" ></td>
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
@endsection