      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">OMDB Jex</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">OS</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">{{__('PAGES') }}</li>
            <li class="dropdown active">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-film"></i><span>{{__('Movies') }}</span></a>
              <ul class="dropdown-menu">
                <li  class="{{ Route::is('dashboard*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('dashboard') }}">{{__('Search Movies') }}</a></li>
                <li  class="{{ Route::is('favorite*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('favorite') }}">{{__('Favorite Movies') }}</a></li>
              </ul>
            </li>
      </div>