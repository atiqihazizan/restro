<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" href="/img/logo.png" sizes="32x32" />
    <link rel="icon" href="/img/logo.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="/img/logo.png" />
    <title>Restro {{ isset($title) ? '| ' . $title : '' }} </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="table" content="0">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <link rel="shortcut icon" href="{{URL::asset('img/logo.png')}}" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/font-awesome/css/all.css')}}" />

    <!-- MDB -->
    <link rel="stylesheet" href="{{ URL::asset('/css/plugin/compiled.min.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('/css/plugin/mdb.min.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('/css/ui-kit/mdb.min.css')}}" />

    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <style>
    </style>
</head>
<body class="bg-black">

<main style="display: inline-flex;">
    <div id="page_1" class="page-frame bg-black animation active faster slide-in-left">@include('ordering.page-table')</div>
    <div id="page_2" class="page-frame gray-black animation d-none faster slide-in-left">@include('ordering.page-menu')</div>
</main>

@stack('modal')

<script type="text/javascript" src="{{URL::asset('/js/plugin/mdb.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('/js/plugin/scripts.bundle.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('/js/plugin/axios.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('/js/plugin/moment.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('/js/mqttws31.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('/js/main.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('/js/mah.js')}}"></script>
<script>
    const APP_URL = `{{ URL::asset('') }}`
    
    if (typeof pahoMQTT === 'function') {
        pahoMQTT();
    }
</script>
@stack('javascript')

</body>
</html>
