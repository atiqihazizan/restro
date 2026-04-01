<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" href="/img/logo.png" sizes="32x32" />
    <link rel="icon" href="/img/logo.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="/img/logo.png" />
    <title>Weng Feng {{ isset($title) ? '| ' . $title : '' }} </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    @stack('meta')
    <link rel="shortcut icon" href="{{URL::asset('img/logo.png')}}" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('/font-awesome/css/all.css')}}" />

    <!-- MDB -->
    <link rel="stylesheet" href="{{ URL::asset('/css/plugin/compiled.min.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('/css/plugin/mdb.min.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('/css/ui-kit/mdb.min.css')}}" />

    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <style>
        .gray-black { background-color: #393939; color: #f5f5f5 }
        .h-topbar { height: 70px !important;}
        /*main, .top-bar { max-width: 1220px; }*/
        main {margin: auto;margin-top: 0px;}
        /*.side-left { width: 160px; }*/
    </style>
@stack('style')
</head>
<body class="bg-black">
<header>
    <nav class="navbar navbar-expand-lg fixed-top navbar-scroll navbar-scrolled gray-black shadow-0 h-topbar">
        <div class="container-fluid ps-0">

            <a class="navbar-brand nav-link" href="{{ route('ordering.table') }}">
                <h4 class="text-white-50 my-0 fs-2x me-2">WENGFENG</h4>
                {{--<h4 class="text-success  my-0 fw-600">RESTRO</h4>--}}
            </a>
            <!-- navbar right -->
            <ul class="navbar-nav ms-auto d-flex flex-row">
                <li class="nav-item">
                    {{--@yield('toprightbar')--}}
                </li>
            </ul>

        </div>
    </nav>
</header>

<main>
    @yield('pages')

</main>
@stack('modal')

<script type="text/javascript" src="{{URL::asset('/js/plugin/mdb.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('/js/plugin/scripts.bundle.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('/js/plugin/axios.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('/js/main.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('/js/mah.js')}}"></script>
<script>
    const APP_URL = '{{ URL::asset('') }}'
</script>
@stack('javascript')
</body>
</html>
