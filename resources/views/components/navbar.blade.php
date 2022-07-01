<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container-fluid">
        <a href="{{ route('home') }}" class="navbar-brand">
            <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
            <strong>CookTake</strong>
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('recipesearch') }}"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>{{ __('messages.Search') }}</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a href="{{ route('recipecreate') }}" class="nav-link">{{ __('messages.Make a Recipe') }}</a>
                    </li>
                @endauth
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">{{ __('messages.Language') }}</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item"
                                href="{{ route('lang', 'lv') }}">{{ __('messages.Latvian') }}</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                                href="{{ route('lang', 'en') }}">{{ __('messages.English') }}</a>
                        </li>
                    </ul>
                </li>
                @if (Route::has('login'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">{{ __('messages.Account') }}</a>
                        @auth
                            {{-- Regular user --}}
                            {{-- Admin --}}
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="">Profile</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a class="dropdown-item" href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        @else
                            {{-- Guest --}}
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item"
                                        href="{{ route('login') }}">{{ __('messages.Login') }}</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('register') }}">{{ __('messages.Register') }}</a></li>
                            </ul>
                        @endauth
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
