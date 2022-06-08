@extends('frontend.master')
@section('title','Blog Post')
@section('content')
<!-- start blog-main -->
<section class="blog-main blog-details-content section-padding">
  <div class="container">
      <div class="row">
          <div class="blog-content col col-md-8">
              <div class="post">
                  <div class="entry-header">
                      <div class="entry-date-media">
                        <div class="entry-media" style="border: 5px solid black">
                          <img src="{{ asset ('blogposts/'.$postdetails->blo_image) }}" class="img img-responsive img-rounded" style="width:100%; height:500px;"alt="{{ $postdetails->blo_title }}">
                        </div>
                      </div>

                      <div class="entry-formet">
                          <div class="entry-meta">
                              <div class="cat">
                                  <i class="fa fa-tags"></i>
                                  <a href="{{ url('blog/category/'.Str::slug($postdetails->blogcategor->blogcat_title).'/'.$postdetails->blogcategor->id) }}">{{ $postdetails->blogcategor->blogcat_title }}</a>
                              </div>
                              <div class="cat">
                                <i class="fa fa-eye"><span>{{ $postdetails->views }} Views</span></i>
                              </div>
                          </div>
                      </div>

                      <div class="entry-title">
                          <h3>{{ $postdetails->blo_title }}</h3>
                      </div>
                  </div>
                  <!-- end of entry-header -->

                  <div class="entry-content">
                    {!!$postdetails->blo_details!!}
                  </div>
                  <!-- end of entry-content -->
              </div>

              <div class="tag-social-share">
                  <div class="tag">
                    @foreach ($postdetails->blogtags as $singleposttag )
                      <a href="{{ url('blog/tag/'.Str::slug($singleposttag->blogtag_title).'/'.$singleposttag->id) }}">{{ $singleposttag->blogtag_title }}</a>
                    @endforeach
                  </div>
                  
                  <div class="social-share">
                    <p>Share Now:</p>
                      <!-- Go to www.addthis.com/dashboard to customize your tools -->
                      <div class="addthis_inline_share_toolbox"></div>
                  </div>
              </div>

              <h3 style="text-align: center;">{{ count($postcomments) }} comments</h3>

              @if (count($postcomments)>0)
                @foreach ($postcomments as $comment )
                  <div class="col-lg-12 margin-tb">
                      <div class="pull-left">
                          @if ($message=Session::get('success'))
                              <div class="alert alert-success">
                                  <p>{{ $message }}</p>
                              </div>
                          @endif
                      </div>
                  </div>
                  <div class="media g-mb-30 media-comment">
                    <img class="d-flex g-width-50 g-height-50 rounded-circle g-mt-3 g-mr-15 image-responsive" src="{{ asset('usersimages'.'/'.$comment->user->avatar) }}" alt="Image Description">
                    <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30" id="accordion" style="box-shadow: 3px 3px 3px 3px #888888; border: 2px solid green;">
                      <div class="g-mb-15">
                        @if ($comment->user->is_admin==1)
                          <h5 class="h5 g-color-gray-dark-v1 mb-0">Admin</h5>
                        @else
                          <h5 class="h5 g-color-gray-dark-v1 mb-0">{{ $comment->user->name }}</h5>
                        @endif
                        
                        <span class="g-color-gray-dark-v4 g-font-size-12">{{ $comment->created_at->diffforhumans()  }}</span>
                      </div>
                      <p>{{ $comment->comment }}</p>
                      <ul class="list-inline d-sm-flex my-0">
                        @if (Auth::id()==$comment->user->id)
                          <li class="list-inline-item g-mr-20">
                            <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#!">
                              edit
                            </a>
                          </li>
                          <li class="list-inline-item g-mr-20">
                            <a href="{{ url('blog/comment/'.$comment->id.'/delete') }}" class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" >
                              delete
                            </a>
                          </li>
                        @endif
                        {{-- <li class="list-inline-item ml-auto">
                          @if (Auth::check())
                            @if (count($postcomments->replies)>0)
                              <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" role="button" data-toggle="collapse" href="#collapse-2" aria-expanded="true" aria-controls="collapse-1">
                                <i class="fa fa-reply g-pos-rel g-top-1 g-mr-3"></i>
                                {{ count($postcomments->replies) }}Replies
                              </a>
                            @else
                                <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" role="button" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                                  <i class="fa fa-reply g-pos-rel g-top-1 g-mr-3"></i>
                                  Reply
                                </a>
                            @endif
                          @else
                            <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#" data-toggle="modal" data-target="#RegistrationModal">
                              <i class="fa fa-reply g-pos-rel g-top-1 g-mr-3"></i>
                              Reply
                            </a>
                          @endif
                        </li> --}}
                      </ul>

                      {{-- <div id="collapse-2" class="collapse show" data-parent="#accordion" aria-labelledby="heading-1" style="border: 2px solid black;">
                        @if (count($replies)>0)
                          @foreach ($postcomments->replies as $reply )
                            <div class="d-flex flex-start mt-4">
                              <a class="me-3" href="#">
                                <img
                                  class="rounded-circle shadow-1-strong"
                                  src="{{ asset('usersimages'.'/'.$reply->user->avatar) }}"
                                  alt="avatar"
                                  width="65"
                                  height="65"
                                />
                              </a>
                              <div class="flex-grow-1 flex-shrink-1">
                                <div>
                                  <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-1">
                                      @if ($reply->user->is_admin==1)Admin
                                      @else{{ $reply->user->name }}
                                      @endif
                                    <span class="small">{{ $reply->created_at->diffforhumans()  }}</span>
                                    </p>
                                  </div>
                                  <p class="small mb-0">
                                    {{ $reply->reply }}
                                  </p>
                                  <ul class="list-inline d-sm-flex my-0">
                                    @if (Auth::id()==$reply->user->id)
                                      <li class="list-inline-item g-mr-20">
                                        <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#!">
                                          edit
                                        </a>
                                      </li>
                                      <li class="list-inline-item g-mr-20">
                                        <a href="#" class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" >
                                          delete
                                        </a>
                                      </li>
                                    @endif
                                  </ul>
                                </div>
                              </div>
                            </div>
                          @endforeach
                          
                          <div class="d-flex flex-column comment-section">
                            <div class="bg-light p-2">
                                @if ($errors)
                                  @foreach ($errors->all() as $error)
                                    <p class="text-danger">{{ $error }}</p>
                                  @endforeach
                                @endif
                                <form method="post" action="{{ route ('commentreply',['id'=>$postdetails->id]) }}" role="form">
                                  @csrf
                                  <div class="d-flex flex-row align-items-start">
                                    {{-- <img class="rounded-circle" src="{{ asset('usersimages'.'/'.$postdetails->user->avatar) }}" width="40"> 
                                    <textarea class="form-control ml-1 shadow-none textarea" name="reply" style="border: 1px solid black;"></textarea>
                                  </div>
                                  <div class="mt-2 text-right">
                                    <button class="btn btn-primary btn-sm shadow-none" type="submit">Reply</button>
                                  </div>
                              </form>
                            </div>
                          </div>
                        @endif
                      </div> --}}
                    </div>
                  </div>
                @endforeach
              @else
                <p>No Comment Added for now</p>
              @endif

              @if (Auth::check())

                <div class="d-flex flex-column comment-section">
                  <div class="bg-light p-2">
                      @if ($errors)
                        @foreach ($errors->all() as $error)
                          <p class="text-danger">{{ $error }}</p>
                        @endforeach
                      @endif
                      <form method="post" action="{{ route ('postcomment',['id'=>$postdetails->id]) }}" role="form">
                        @csrf
                        <div class="d-flex flex-row align-items-start">
                          {{-- <img class="rounded-circle" src="{{ asset('usersimages'.'/'.$postdetails->user->avatar) }}" width="40"> --}}
                          <textarea class="form-control ml-1 shadow-none textarea" name="comment" style="border: 1px solid black;"></textarea>
                        </div>
                        <div class="mt-2 text-right">
                          <button class="btn btn-primary btn-sm shadow-none" type="submit">Post comment</button>
                        </div>
                    </form>
                  </div>
                </div>
              @else

                <div class="mt-2 text-right">
                  <a href="#" data-toggle="modal" data-target="#RegistrationModal">
                    <button class="btn btn-primary btn-sm shadow-none">Log in To add a comment</button>
                  </a>
                </div>
              @endif
          </div>
        
          @include('frontend.blogsidebar')
          <!-- end of sidebar -->

      </div>
  </div>
          
</section>
<!-- end of blog-main -->
<!-- Recommended posts end -->
<section class="related-posts p-2 mt-2">
  <h3 class="text-center">Related posts</h3>
    <div class="row">
      
        @forelse ($relatedposts as $singlepost)
        <div class="col-lg-3 col-md-6">
          <div class="swiper-slide">
              <div class="ms_rcnt_box">
                  <div class="ms_rcnt_box_img">
                    <img src="{{ asset('blogposts'.'/'.$singlepost->blo_image) }}" alt="{{ $singlepost->blo_title }}" style="width:100%; height:200px;">
                  </div>
                  <div class="ms_rcnt_box_text">
                    <h3><a href="{{ url('blog/post/'.Str::slug($singlepost->blo_title).'/'.$singlepost->id) }}">{{ $singlepost->blo_title }} </a></h3>
                  </div>
              </div>
          </div>
        </div>
        @empty
          
        @endforelse
        
      
    </div>
</section>

@endsection

  