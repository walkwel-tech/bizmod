<header class="header">
    <nav class="navbar navbar-light navbar-expand-md ">
        <div class="container container_brand">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('logo.png') }}"
                    class="navbar-brand-img"
                    alt="{{ config('app.name', 'Walkwel') }}">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('basic.routes.login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('basic.routes.register') }}</a>
                    </li>
                    @else

                    {{--
                    <li class="nav-item">
                        <a class="nav-link notification_alert" href="{{ route('register') }}">
                            <img src="{{asset('images/bell-icon.png')}}" alt="">Notifications<span></span>
                        </a>
                    </li>
                    --}}

                    <li class="nav-item mobile-menu">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                            {{ __('basic.routes.logout') }}
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            title="{{ auth()->user()->name }} | {{ config('app.name', 'Walkwel') }}"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{ auth()->user()->getImage() }}" alt="{{ auth()->user()->name }} | {{ config('app.name', 'Walkwel') }}">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @can('backend.access')
                            <a href="{{ route('admin.home') }}" class="dropdown-item">{{ __('basic.routes.admin') }}</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                {{ __('basic.routes.logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
