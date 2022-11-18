<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
 
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
</head>
<body background="../fondo-1.png">

    <div id="app">
        

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
