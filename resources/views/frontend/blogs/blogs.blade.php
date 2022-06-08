
@extends('frontend.master')
@section('title','VOSKILL BLOG')
@section('content')
<!-- Archive content -->
<section class="archive-content">
  <div class="container">
      <div class="row " id="main-content">
          <div class=" col-lg-8 content">
              <!-- Archive posts -->
              <div class="archive-posts theiaStickySidebar">
                  <h1>Trending News And Music Releases</h1>
                  @if (count($posts)>0)
                    @foreach ($posts as $blog)
                        <div class="card mb-5">
                            <div class="row no-gutters align-items-center align-items-center">
                                <h5 class="card-title title-font" style=" width:100%;"><a href="{{ url('blog/post/'.Str::slug($blog->blo_title).'/'.$blog->id) }}"><span>{{ $blog->id }}.</span>{{ $blog->blo_title }}</h5>
                                <div class="col-md-4" style="border: 2px solid black;">
                                    <a href="{{ url('blog/post/'.Str::slug($blog->blo_title).'/'.$blog->id) }}">
                                        <img src="{{ asset('blogposts/'.$blog->blo_image) }}" class="rounded  img-fluid h-100" alt="{{ $blog->blo_title }}">
                                    </a>
                                </div>
                                <div class="col-md-8"> 
                                    <div class="card-body">
                                        <div class="blog-meta">
                                            <!--date and time the article was published-->
                                            <i class="fa fa-clock"><span>{{$blog->created_at->diffforhumans()}}</span></i>
                                            <!--category the article belongs to-->
                                            <a href="{{ url('blog/category/'.Str::slug($blog->blogcategor->blogcat_title).'/'.$blog->blogcategor->id) }}"><i class="fa fa-rss-square"><span>{{ $blog->blogcategor->blogcat_title }}</span></i></a>
                                            <!--comments for the article-->
                                            {{-- <a href="#"><i class="fa fa-comments"><span>{{ count($blog->blogcomments) }} Comments</span></i></a> --}}

                                            <p class="card-text">
                                                {!!str_limit($blog->blo_details,255)!!}
                                                <div class="stage">
                                                <a href="{{ url('blog/post/'.Str::slug($blog->blo_title).'/'.$blog->id) }}">Read More</a>
                                                </div>
                                            <p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                  @else
                   <h3>No Trending News Or Music Releases Found</h3>
                  @endif 
              </div>
              <div class="d-flex justify-content-center">
                    {!! $posts->links() !!}
               </div>
          </div>
          
          @include('frontend.blogsidebar')
      </div>
  </div>
</section>
<!-- Archive content end -->
@endsection

