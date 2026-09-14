<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('assets/dist/img/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{ route('courier.profile', ['language'=>app()->getLocale(), 'user'=>auth()->user()->id]) }}" class="d-block">
          {{__('Courier')}} ({{auth()->user()->name}})
        </a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('courier.profile', ['language'=>app()->getLocale(), 'user'=>auth()->user()->id]) }}" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              {{__('Profile')}}
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('courier.points', app()->getLocale())}}" class="nav-link">
            <i class="nav-icon fas fa-truck"></i>
            <p>
              {{__('Points')}}
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('logout', app()->getLocale())}}" class="nav-link">
            <i class="nav-icon fas fa-window-close"></i>
            <p>{{__('Log out')}}</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>