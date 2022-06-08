
@extends('frontend.master')
@section('title','VOSKILL')
@section('content')

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
                                      {{-- <a href="#"><i class="fa fa-comments"><span>{{ count($blog->blogcomments) }} Comments</span></i></a> --}}
  
                                      <p class="card-text">{{ str_limit($blog->blo_details,255)}}
                                          <div class="stage">
                                             <a href="{{ url('blogpost/'.Str::slug($blog->blo_title).'/'.$blog->id) }}">Read More</a>
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
                <!-- Archive posts end -->
                {{-- <!-- Pagination section -->
                <section class="pagination-section">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1"><i class="fas fa-arrow-left"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="fas fa-arrow-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </section>
                <!-- pagination section end  --}}
            </div>
            
            <div class=" col-lg-4 sidebar">
                <!-- Sidebar posts -->
                <div id="sticker" class="theiaStickySidebar">
                    <div class="sidebar-posts">
                      <div class="sidebar-title">
                          <h5>Popular Posts</h5>
                      </div>
                      <div class="sidebar-content p-0">
                          @foreach ( $posts as $blog)
                          <div class="card border-0">
                          <div class="row no-gutters align-items-center">
                              <div class="col-3 col-md-3">
                                  <a href="#">
                                      <img src="{{ asset('blogimages',$blog->blo_image) }}" class="card-img" alt="">
                                  </a>
                              </div>
                              <div class="col-9 col-md-9">
                                  <div class="card-body">
                                      <h5 class="card-title title-font"><a href="#">{{ $blog->blo_name }}</a>
                                      </h5>
                                      <div class="author-date">
                                          <a class="author" href="#">
                                              <span class="writer-name-small">Category</span>
                                          </a>
                                          <a class="date" href="#">
                                              <span>{{ $blog->created_at}}</span>
                                          </a>
                                      </div>
                                  </div>
                              </div>
                              </div>
                      </div>
                          @endforeach
                      </div>
                    </div>
                    <div class="popular-tags mt-4">
                        <div class="sidebar-title">
                            <h5>Popular tags</h5>
                        </div>
                        <div class="sidebar-content">
                            <ul class="sidebar-list tags-list">
                                <li><a href="#">Food</a></li>
                                <li><a href="#">Technology</a></li>
                                <li><a href="#">UI/UX</a></li>
                                <li><a href="#">Diet</a></li>
                            </ul>
                        </div>
  
                    </div>
                    <div class="sidebar-posts mt-4">
                        <div class="sidebar-title">
                            <h5>Archive</h5>
                        </div>
                        <div class="sidebar-content">
                            <ul class="archive-date-list">
                                <li><a href="#"><img src="assets/images/archive-icon.svg" alt=""> December
                                        2019</a></li>
                                <li><a href="#"><img src="assets/images/archive-icon.svg" alt=""> November
                                        2019</a></li>
                                <li><a href="#"><img src="assets/images/archive-icon.svg" alt=""> October
                                        2019</a></li>
                                <li><a href="#"><img src="assets/images/archive-icon.svg" alt=""> September
                                        2019</a></li>
                                <li><a href="#"><img src="assets/images/archive-icon.svg" alt=""> August
                                        2019</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-posts mt-4">
                        <div class="sidebar-title">
                            <h5>Blog Categories</h5>
                        </div>
                        <div class="sidebar-content">
                            <div class="category-name-list">
                                <div class="card small-card">
                                    <a href="#"><img src="assets/images/shoes.jpg" class="card-img"
                                            alt="" /></a>
                                    <div class="card-img-overlay">
                                        <h5 class="card-title title-font mb-0">
                                            <a href="#">Travel</a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="recent-posts mt-4" style="border: 2px solid rgb(253, 0, 84);">
                      <div class="sidebar-title">
                        <h5><i class="fas fa-circle"></i>Recent Posts</h5>
                      </div>
                      <div class="sidebar-content">
                        <ul class="sidebar-list">
                          @if ($recent_posts)
                            @foreach ($recent_posts as $posts )
                              <li class="sidebar-item">
                                <div class="num-left">
                                  {{ $posts->id }}
                                </div>
                                <div class="content-right">
                                  <a href="#">{{ $posts->blo_title }}</a>
          
                                </div>
                              </li>
                            @endforeach
                          @endif
                        </ul>
                      </div>
                    </div>
                </div>
                <!-- Sidebar posts end -->
            </div>
        </div>
    </div>
  </section>

@endsection