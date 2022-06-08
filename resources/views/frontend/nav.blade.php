<?php use App\Models\Cart; ?>
<?php use App\Models\Merchadisecategory; ?>
<?php use App\Models\Merchadise;
  $cartcount=Merchadise::cartcount();
?>

<header class="header">
  <div class="header-inner" style="background:rgb(224, 210, 13);">
      <div class="container-fluid px-lg-5">
          <nav class="navbar navbar-expand-lg my-navbar">
              <a class="navbar-brand" href="{{route ('index') }}"><span class="logo">
                  <img src="dist/frontend/images/DjVoskillLogo.jpg" alt="Dj Voskill" class="img-fluid" style="width:30px; margin:-3px 0px 0px 0px;">Dj Voskill</span>
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"><i class="fas fa-bars" style="margin:5px 0px 0px 0px;"></i></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav m-auto">
                    <li class="nav-item {{'/'==request()->path()?'active':' ' }}">
                      <a class="nav-link" href="{{route ('index') }}">Home<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item {{'audiomixtapes'==request()->path()?'active':' ' }}">
                      <a class="nav-link" href="{{route ('audiomixtapes') }}">Mixxes</a>
                    </li>
                    <li class="nav-item {{'events'==request()->path()?'active':' ' }}">
                      <a class="nav-link" href="{{route ('events') }}">Events</a>
                    </li>
                    {{-- <li class="nav-item">
                      <a class="nav-link" href="{{route ('merchadise') }}">Our Merchadise</a>
                    </li> --}}
                    <li class="nav-item dropdown 
                      {{-- {{ Request::is('blog/*') ? 'active' : null }} --}}
                    ">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Our Merchadise
                      </a>
                      <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
                        <?php 
                          $caturls=Merchadisecategory::select('url')->where('status',1)->get()->pluck('url');
                        ?>
                          @foreach ( $caturls as $cat )
                            <li class="nav-item {{ Request::is('/'.$cat) ? 'active' : null }}">
                              <a class="dropdown-item" href="{{ url('/'.$cat) }}">{{ Ucwords($cat) }}</a>
                            </li>
                          @endforeach
                      </ul>
                    </li>
                    <li class="nav-item dropdown {{ Request::is('blog/*') ? 'active' : null }}">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Blog
                      </a>
                      <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
                        <?php $cats=DB::table('blogcategories')->get();?>
                        @foreach ( $cats as $cat )
                          <li class="nav-item {{ Request::is('blog/category/{slug}/{id}') ? 'active' : null }}"><a class="dropdown-item" href="{{ url('blog/category/'.Str::slug($cat->blogcat_title).'/'.$cat->id) }}">{{ Ucwords($cat->blogcat_title) }}</a></li>
                        @endforeach
                      </ul>
                    </li>
                    <li class="nav-item {{'contact'==request()->path()?'active':' ' }}">
                      <a class="nav-link" href="{{route ('contact.index') }}">Contact Us</a>
                    </li>
                  </ul>
                  <ul class="navbar-nav navbar-nav-right">
                    @guest
                    <li class="nav-item nav-profile dropdown">
                      <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <span class="nav-profile-name">Login/Sign up</span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#LogInModal">Log in</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#RegistrationModal">Register</a>
                      </div>
                    </li>
                    @else
                    <li class="nav-item nav-profile dropdown">
                      <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <img src="/usersimages/{{ Auth::user()->avatar }}" style="width: 32px;
                        height: 32px;
                        border-radius: 100%;" alt="profile"/>
                        <span class="nav-profile-name">{{ Auth::user()->name }}</span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="{{ route('userprofile.show',Auth::user()->id)}}">
                          <i class="mdi mdi-settings text-primary"></i>
                          My Account
                        </a>
                        @if (Auth::user()->is_admin==1)
                          <a class="dropdown-item" href="{{ route('dashboard.index')}}">
                            <i class="mdi mdi-settings text-primary"></i>
                            Admin Dashboard
                          </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                          @csrf
            
                          <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="mdi mdi-logout text-primary"></i>Logout
                          </a>
                        </form>
                      </div>
                    </li>
                    @endguest
                    <li class="nav-item">
                      <!-- Header Shop Links Start -->
                      <div class="header-shop-links">
                        <!-- Cart -->
                        <a href="{{ url('/mycart') }}" class="nav-link">
                          <i class="fas fa-shopping-cart"></i>
                          <span class="number" style="background: white;">{{ $cartcount }}</span>
                        </a>
                      </div>
                       <!-- Header Shop Links End -->
    
                    </li>
                  </ul>
              </div>
          </nav>
      </div>
  </div>
</header>

