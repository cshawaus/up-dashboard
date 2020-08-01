<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <title>{{ $page['props']['app.name'] }}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
  <script src="{{ mix('/js/app.js') }}" defer></script>
</head>
<body>

  @inertia

</body>
</html>
