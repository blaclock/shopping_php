<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"content="IE=edge">
    <meta name="viewport"content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"href="{{ App\consts\CommonConst::CSS_PATH }}output.css">
    <link rel="stylesheet"href="{{ App\consts\CommonConst::CSS_PATH }}style.css">
    <link rel="stylesheet"href="{{ App\consts\CommonConst::CSS_PATH }}header_menu.css">@stack('css') <title>
        Document</title>
</head>

<body>
    @component('components.header', [
        'headerBgColor' => 'white',
        'headerBgColorSp' => 'gray-700',
        'headerTextColor' => 'gray-600',
        'headerTextColorSp' => 'white',
        'user' => 'customer',
    ])
    @endcomponent
    <div class="bg-gray-50 py-10 md:py-20 min-h-screen md:mt-[80px]">
        <div class="container px-5 mx-auto">@yield('content') </div>
    </div>
    @component('components.footer', [
        'footerBgColor' => 'white',
        'footerTextColor' => 'gray-600',
        'user' => 'customer',
    ])
    @endcomponent
</body>

</html>
