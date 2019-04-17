<!DOCTYPE html>
<html lang="ru">
    <head>
        @include('layouts.head')
        <link href="css/app.css" rel="stylesheet" type="text/css">
    </head>
    <body>        
        <div class="container">            
            @yield('content')
        </div>
        
        <script type="text/javascript" src="js/app.js"></script>
    </body>
</html>