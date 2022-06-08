@extends('frontend.master')
@section('title', 'All Blog Categories')
@section('content')
<section class="single-layout">
  <div class="container_fluid">
    <div class="row">
      <div class="col-lg-8 content">
        <div class="row">
            <div class="col-lg-6" >
                @if (count($allcategories)>0)
                    @foreach ( $allcategories as $category )
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->blogcat_title }}</h5>
                            <a href="#" class="btn btn-info">Blogposts For the Category</a>
                          </div>
                        <img src="{{ asset('blogcategories/'.$category->blogcat_image) }}"
                          class="card-img-top" style="height:40%;"
                          alt="{{ $category->blogcat_title }}"
                        />
                    </div>
                    <br/>
                    @endforeach
                @else
                <p>No Blog Category Found</p>
                @endif
            </div>
        </div>
        {{ $allcategories->links() }}
      </div>
      <div class="col-lg-4 sidebar" style="border: 2px solid rgb(253, 0, 84)">
        <div id="sticky-single" class="theiaStickySidebar">
          <div class="sidebar-posts">
            <div class="sidebar-title">
              <h5><i class="fas fa-circle"></i>Popular Posts</h5>
            </div>
            @foreach ($recent_posts as $blog)
            <div class="sidebar-content" style="border: 2px solid rgb(32, 241, 5)">
              <div class="card border-0">
                <div class="row no-gutters align-items-center">
                  <div class="col-3 col-md-3">
                    <a href="#">
                      <img src="{{ url('blogimages',$blog->blo_image) }}" class="card-img" alt="">

                    </a>
                  </div>
                  <div class="col-9 col-md-9">
                    <div class="card-body">
                      <ul class="category-tag-list mb-0">
                        <li class="category-tag-name">
                          <a href="#">Lifestyle</a>
                        </li>
                      </ul>
                      <h5 class="card-title title-font"><a href="#">{{$blog->blo_name}}</a>
                      </h5>
                      <div class="author-date">
                          <span>{{$blog->created_at}}</span>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            @endforeach 
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
      </div>
    </div>
  </div>
</section>

<section class="related-posts">
  <div class="container">
    <div class="related-title">
      <h3>Related posts</h3>
    </div>
    <div class="row">
      <div class="col-md-6 col-lg-3">
        <div class="card small-card simple-overlay-card">
          <a href="#"><img src="assets/images/town-street.jpg" class="card-img" alt="" /></a>
          <div class="card-img-overlay">
            <ul class="category-tag-list mb-0">
              <li class="category-tag-name">
                <a href="#">Travel</a>
              </li>
            </ul>
            <h5 class="card-title title-font">
              <a href="#">Why I love to travel in Spring</a>
            </h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

  