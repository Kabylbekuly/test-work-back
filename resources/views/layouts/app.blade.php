<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>I1 - Сервис для покупки туров и бронирование отелей</title>
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/lib/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    <link rel="icon" href="/favicon.ico">
</head>
<body>
<div id="app" class="app">
    @yield('content')
</div>
{{--<script src="{{ mix('js/vendor.min.js') }}"></script>--}}
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
