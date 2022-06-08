<!-- Adminsidebar open -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item {{ 'admin/dashboard'==request()->path()?'active':' ' }}">
        <a class="nav-link" href="{{ url('admin/dashboard') }}">
          <i class="mdi mdi-home menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item {{ 'admin/*'==request()->path()?'active':' ' }}">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <i class="mdi mdi-circle-outline menu-icon"></i>
          <span class="menu-title">All Users</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item {{ 'admin/admins'==request()->path()?'active':' ' }}"><a class="nav-link" href="{{ route('admins.index') }}">All Admins</a></li>
            <li class="nav-item {{ 'admin/users'==request()->path()?'active':' ' }}"><a class="nav-link" href="{{ route('users.index') }}">All Normal Users</a></li>
          </ul>
        </div>
      </li>
      @can('is-admin')
        <li class="nav-item {{ 'admin/roles'==request()->path()?'active':' ' }}">
          <a class="nav-link" href="{{ route('roles.index') }}">
            <i class="mdi mdi-view-headline menu-icon"></i>
            <span class="menu-title">Roles</span>
          </a>
        </li>
      @endcan
      <li class="nav-item {{ 'admin/mixxes'==request()->path()?'active':' ' }}">
        <a class="nav-link" href="{{ route('mixxes.index') }}">
          <i class="mdi mdi-grid-large menu-icon"></i>
          <span class="menu-title">Mixtapes</span>
        </a>
      </li>
      <li class="nav-item {{ 'admin/events'==request()->path()?'active':' ' }}">
        <a class="nav-link" href="{{ route('events.index') }}">
          <i class=" mdi mdi-calendar-clock menu-icon"></i>
          <span class="menu-title">Events</span>
        </a>
      </li>
      <li class="nav-item {{ 'admin/*'==request()->path()?'active':' ' }}">
        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <i class="mdi mdi-account menu-icon"></i>
          <span class="menu-title">Blog Posts</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item {{ 'admin/blogost'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('blogpost.index') }}"> All Blogposts </a></li>
            <li class="nav-item {{ 'admin/blogcategory'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('blogcategory.index') }}"> All Post Categories</a></li>
            <li class="nav-item {{ 'admin/blogtags'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('blogtags.index') }}"> All Post Tags </a></li>
            <li class="nav-item {{ 'admin/postcomments'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ url('admin/postcomments') }}"> All Post Comments </a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{ 'admin/*'==request()->path()?'active':' ' }}">
        <a class="nav-link" data-toggle="collapse" href="#merchadise" aria-expanded="false" aria-controls="merchadise">
          <i class="mdi mdi-account menu-icon"></i>
          <span class="menu-title">Merchadise</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="merchadise">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item {{ 'admin/merchadisecategory'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('merchadisecategory.index') }}"> All Product Categories</a></li>
            <li class="nav-item {{ 'admin/merchadise'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('merchadise.index') }}"> All Merchadise </a></li>
            <li class="nav-item {{ 'admin/merchadise/merchadisesections'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('merchadisesections.index') }}"> All Product Sections</a></li>
            <li class="nav-item {{ 'admin/shippingcharges'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('shippingcharges') }}"> Shipping Charges </a></li>
            <li class="nav-item {{ 'admin/coupons'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('coupons.index') }}"> Coupons For Our Merchadise </a></li>
            <li class="nav-item {{ 'admin/mpesapayments'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('mpesapayments.index') }}"> Payments Made by Mpesa </a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{ 'admin/*'==request()->path()?'active':' ' }}">
        <a class="nav-link" data-toggle="collapse" href="#bookings" aria-expanded="false" aria-controls="bookings">
          <i class="mdi mdi-account menu-icon"></i>
          <span class="menu-title">Boookings Manager</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="bookings">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item {{ 'admin/bookingcategory'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('bookingcategory.index') }}"> Bookings Categories</a></li>
            <li class="nav-item {{ 'admin/received'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('receivedbookings') }}"> Bookings Recieved From Clients </a></li>
            <li class="nav-item {{ 'admin/received'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('approvedbookings') }}"> Bookings Approved by Manager </a></li>
            <li class="nav-item {{ 'admin/received'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('receivedbookings') }}"> Bookings Approved by Accountant </a></li>
            <li class="nav-item {{ 'admin/received'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('receivedbookings') }}"> Published Bookings </a></li>
            <li class="nav-item {{ 'admin/received'==request()->path()?'active':' ' }}"> <a class="nav-link" href="{{ route('receivedbookings') }}"> Cancelled Bookings </a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pages/icons/mdi.html">
          <i class="mdi mdi-emoticon menu-icon"></i>
          <span class="menu-title">Admin Settings</span>
        </a>
      </li>
    </ul>
  </nav>
  <!-- Adminsidebar close -->