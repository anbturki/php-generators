<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{asset('/css/app.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

        window.baseUrl = "{{url('/')}}";
    </script>
</head>
<body>
@if(Auth::check())
    <div>
        <nav class="navbar navbar-default navbar-fixed-top card">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>

                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/') }}">Dahsboard</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{trans('generators.Generators')}} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('generators.index') }}">{{trans('generators.Generators')}}</a></li>
                                <li><a href="{{ route('generators.create') }}">{{trans('generators.Generator_Add_New')}}</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('maintenances::index') }}">Maintenance log</a></li>
                        <li><a href="{{ route('overhauls::index') }}">Overhauls log</a></li>
                    </ul>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('auth::edit') }}">Edit Profile</a></li>
                                <li><a href="{{ route('register') }}">Add user</a></li>
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>
@endif
<br>
<br>
<br>
       <div class="container">
            @yield('content')
       </div>
    </div>
<br><br>
<br><br>
    <div class="page-loading">
        <div class="loader">Loading...</div>
    </div>
    <!-- Scripts -->
    <script src="{{asset('/js/app.js')}}"></script>
    <script src="{{asset('/js/all.js')}}"></script>
</body>
</html>
