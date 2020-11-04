<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')
        @auth
            @php($notifications = auth()->user()->unreadNotifications ?? null)
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    @if( isset($notifications) && $notifications->count()>0)
                        <span class="badge badge-warning navbar-badge">{{ $notifications->count() }}</span>
                    @endisset
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">{{ isset($notifications)?$notifications->count():0 }} Notificaciones</span>
                    <div class="dropdown-divider"></div>
                    @isset($notifications)
                        @foreach ($notifications->take(5) as $notification)
                            <a href="{{ route('notification.unread', ['id' => $notification->id]) }}" class="dropdown-item text-xs">
                                <i class="fas fa-{{ $notification->data['icon'] }} mr-2"></i> {{ $notification->data['message_left'] }}
                                <span class="float-right text-muted">{{ $notification->data['message_right'] }}</span>
                            </a>
                            <div class="dropdown-divider"></div>
                        @endforeach
                    @endisset                            
                </div>
            </li>                    
        @endauth
        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
