
@extends('frontend.master')
@section('title','SearchResults')
@section('content')
<!-- Archive content -->
<section class="archive-content">
  <div class="container">
      <div class="row " id="main-content">
          <div class=" col-lg-8 content">
              <!-- Archive posts -->
              <div class="archive-posts theiaStickySidebar">
                  <h2>Search Results for:{{ request()->input('query') }}</h2>
                  @if ($data->count()>0)
                    @foreach ($data as $blog)
                        <div class="card mb-5">
                            <div class="row no-gutters align-items-center align-items-center">
                                <h5 class="card-title title-font" style="border: 2px solid rgb(16, 255, 8); width:100%;"><a href="{{ url('blogpost/'.Str::slug($blog->blo_title).'/'.$blog->id) }}"><span>{{ $blog->id }}.</span>{{ $blog->blo_title }}</h5>
                                <div class="col-md-4" style="border: 2px solid black;">
                                    <a href="{{ url('blogpost/'.Str::slug($blog->blo_title).'/'.$blog->id) }}">
                                        <img src="{{ asset('blogposts/'.$blog->blo_image) }}" class="card-img img-fluid img-thumbnail" alt="{{ $blog->blo_title }}">
                                    </a>
                                </div>
                                <div class="col-md-8"> 
                                    <div class="card-body">
                                        <div class="blog-meta">
                                            <!--date and time the article was published-->
                                            <i class="fa fa-clock"><span>{{$blog->created_at->diffforhumans()}}</span></i>
                                            <!--category the article belongs to-->
                                            <a href="#"><i class="fa fa-rss-square"><span>{{ $blog->blogcategor->blogcat_title }}</span></i></a>
                                            <!--comments for the article-->
                                            {{-- <a href="#"><i class="fa fa-comments"><span>{{ count($blog->blogcomments) }} Comments</span></i></a>  --}}

                                            <p class="card-text">{{ str_limit($blog->blo_details,255)}}
                                                <div class="stage">
                                                <a href="{{ url('post/'.Str::slug($blog->blo_title).'/'.$blog->id) }}">Read More</a>
                                                </div>
                                            <p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                  @else
                   <h3>No Results Found</h3>
                  @endif 
              </div>
              <div class="d-flex justify-content-center">
                    {!! $data->appends(request()->input())->links() !!}
               </div>
          </div>
          
          @include('frontend.blogsidebar')
      </div>
  </div>
</section>
<!-- Archive content end -->
@endsection

