<nav class="navbar navbar-expand-lg fixed-top py-3" id="mainNav" style="background-color:rgba(0, 0, 0, 1);">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="{{url('/')}}" style="color: white;">Home</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto my-2 my-lg-0">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="{{route('metric.index')}}">Explore Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="{{route('story.index')}}">Persona</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="{{route('district.index')}}">Explore District</a>
                </li>
                @guest
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link js-scroll-trigger" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
                    {{--</li>--}}
                    {{--@if (Route::has('register'))--}}
                        {{--<li class="nav-item">--}}
                            {{--<a class="nav-link js-scroll-trigger" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
                        {{--</li>--}}
                    {{--@endif--}}
                @else
                    @if(auth()->user()->type === 'moderator')
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="{{route('moderator.index')}}">Moderator</a>
                        </li>
                    @endif
                    @if(auth()->user()->type === 'admin')
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="{{route('admin.index')}}">Admin</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="{{ route('user_profile',auth()->user()) }}">
                            {{ Auth::user()->name }}
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>