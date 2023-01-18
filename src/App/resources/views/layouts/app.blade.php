<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"content="IE=edge">
    <meta name="viewport"content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"href="{{ App\consts\CommonConst::CSS_PATH }}output.css">
    <link rel="stylesheet"href="{{ App\consts\CommonConst::CSS_PATH }}header_menu.css">
    @stack('css')
    <title>Document</title>
</head>

<body>
    @include('components.header')

    <div class="bg-gray-50 py-20">
        <div class="container px-5 mx-auto">
            @yield('content')
        </div>
    </div>

    <script src="{{ App\consts\CommonConst::JS_PATH }}header_menu.js"></script>
    @stack('js')
</body>

</html>
