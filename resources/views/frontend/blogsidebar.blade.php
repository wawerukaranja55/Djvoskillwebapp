
  
  <div class="col-md-4 right-sidebar">
    <!-- right sidebar -->
    <div class="row">
        <div class="col-md-12 widget widget-search">
            <!-- widget -->
            <div class="well-box">
                <h4 class="widget-title">Search bar</h4>
                <form method="GET" action="{{ route('search.store') }}">
                  <div class="input-group">
                    <input type="search" name="query" value="{{ request()->input('query') }}" class="form-control"placeholder="Search a Post">
                    <span class="input-group-btn">
                      <button class="btn btn-primary btn-lg" type="submit">
                        <i class="fa fa-search"></i>
                      </button>
                    </span>
                  </div>
                </form>
                <!-- /input-group -->
            </div>
        </div>
        <!-- /.widget -->
        <div class="col-md-12 widget widget-category">
            <!-- widget -->
            <div class="well-box">
                <h4 class="widget-title">Categories</h4>
                <ul class="listnone angle-double-right" style="list-style-type: none;">
                  @foreach ($cats as $blogcat )
                    <li><a href="{{ url('blog/category/'.Str::slug($blogcat->blogcat_title).'/'.$blogcat->id) }}">{{ $blogcat->blogcat_title }}</a>
                      {{-- <span>{{ count($blogcategorys) }}</span> --}}
                    </li>
                  @endforeach
                </ul>
            </div>
        </div>
        <!-- /.widget -->
        
        <div class="col-md-12 widget widget-recent-post">
            <!-- widget -->
            <div class="well-box">
              <div class="sidebar-posts">
                <div class="sidebar-title">
                  <h4>Latest Posts</h4>
                </div>
                @if ($recent_posts)
                  @foreach ($recent_posts as $post )
                  <div class="sidebar-content p-0">
                    <div class="card border-0">
                        <div class="row no-gutters align-items-center">
                            <div class="col-3 col-md-3">
                                <a href="{{ url('blog/post/'.Str::slug($post->blo_title).'/'.$post->id) }}">
                                    <img src="{{ asset('blogposts'.'/'.$post->blo_image) }}" class="card-img" alt="">
                                </a>
                            </div>
                            <div class="col-9 col-md-9">
                                <div class="card-body">
                                    <ul class="category-tag-list mb-0">
                                        <li class="category-tag-name">
                                          <a href="{{ url('blog/category/'.Str::slug($post->blogcategor->blogcat_title).'/'.$post->blogcategor->id) }}" style="font-style: italic; font-size:10px;">{{ $post->blogcategor->blogcat_title }}</a>
                                        </li>
                                    </ul>
                                    <h5 class="card-title title-font"><a href="{{ url('blog/post/'.Str::slug($post->blo_title).'/'.$post->id) }}">{{ $post->blo_title }}</a>
                                    </h5>
                                    <div class="author-date">
                                      <span>{{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                          </div>
                    </div>
                  </div>
                  @endforeach
                @endif
              </div>
            </div>
        </div>
        <!-- /.widget -->
        {{-- <div class="col-md-12 widget widget-archive">
            <!-- widget -->
            {{-- <div class="well-box">
                <h4 class="widget-title">Archives</h4>
                <select id="selectbasic" name="selectbasic" class="form-control">
                    <option value="1">August 2015</option>
                    <option value="2">July 2015</option>
                    <option value="2">June 2015</option>
                </select>
            </div>
        </div> --}}
        <!-- /.widget -->
        <div class="col-md-12 widget widget-tag">
           
            <div class="well-box">
                <h4 class="widget-title">Tags</h4>
                  @foreach ($posttags as $tag )
                  <a href="{{ url('blog/tag/'.Str::slug($tag->blogtag_title).'/'.$tag->id) }}">{{ $tag->blogtag_title }}</a> 
                  @endforeach
            </div>
        </div>
        <!-- /.widget -->
    </div>
  </div>
<!-- /.right sidebar -->

<!-- Start sidebar
<div class="col-md-5 col-lg-4 sidebar">
 Sidebar posts
  <div id="sticker" class="theiaStickySidebar">
    <div class="widget search-widget">
      <h3>Search</h3>
      <form method="GET" action="{{ route('search.store') }}">
          <div class="form-group">
              <input type="search" name="query" value="{{ request()->input('query') }}"class="form-control rounded"  aria-label="Search" placeholder="Search a Post">
          </div>
          <button type="submit" class="btn btn-outline-primary"><i class="fa fa-search"></i></button>
      </form>
    </div>
    <div class="widget categories-widget">
      <h3>Categories</h3>
      <ul>
        @foreach ($cats as $blogcat )
          <li><a href="{{ url('blogcategory/'.Str::slug($blogcat->blogcat_title).'/'.$blogcat->id) }}">{{ $blogcat->blogcat_title }}</a></li>
        @endforeach
      </ul>
    </div>
    <div class="sidebar-posts">
      <div class="sidebar-title">
        <h5>Latest Posts</h5>
      </div>
      @if ($recent_posts)
        @foreach ($recent_posts as $post )
        <div class="sidebar-content p-0">
          <div class="card border-0">
              <div class="row no-gutters align-items-center">
                  <div class="col-3 col-md-3">
                      <a href="{{ url('post/'.Str::slug($post->blo_title).'/'.$post->id) }}">
                          <img src="{{ asset('blogposts'.'/'.$post->blo_image) }}" class="card-img" alt="">
                      </a>
                  </div>
                  <div class="col-9 col-md-9">
                      <div class="card-body">
                          <ul class="category-tag-list mb-0">
                              <li class="category-tag-name">
                                <a href="{{ url('blogcategory/'.Str::slug($post->blogcategor->blogcat_title).'/'.$post->blogcategor->id) }}" style="font-style: italic; font-size:10px;">{{ $post->blogcategor->blogcat_title }}</a>
                              </li>
                          </ul>
                          <h5 class="card-title title-font"><a href="{{ url('blogpost/'.Str::slug($post->blo_title).'/'.$post->id) }}">{{ $post->blo_title }}</a>
                          </h5>
                          <div class="author-date">
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                          </div>
                      </div>
                  </div>
                </div>
          </div>
        </div>
        @endforeach
      @endif
    </div>
    <div class="popular-tags mt-4">
        <div class="sidebar-title">
            <h5>Popular tags</h5>
        </div>
        <div class="sidebar-content">
            <ul class="sidebar-list tags-list">
              @foreach ($posttags as $tag )
              <li><a href="#">{{ $tag->blogtag_title }}</a></li>
              @endforeach
            </ul>
        </div>

    </div>
  </div>
  <!-- Sidebar posts end
</div>
   End sidebar -->