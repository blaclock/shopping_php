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

    <div class="flex bg-gray-50 min-h-screen">
        {{-- sidebar --}}
        <ul class="sidebar py-20 w-1/6 flex flex-col px-4 bg-gray-200">
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/detail"
                class="p-4 mb-4 w-11/12 mx-auto border border-gray-300 hover:bg-gray-100 bg-white">
                <span>登録情報</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/customers"
                class="p-4 mb-4 w-11/12 mx-auto border border-gray-300 hover:bg-gray-100 bg-white">
                <span>顧客情報管理</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/products"
                class="p-4 mb-4 w-11/12 mx-auto border border-gray-300 hover:bg-gray-100 bg-white">
                <span>商品管理</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/orders"
                class="p-4 w-11/12 mx-auto border border-gray-300 hover:bg-gray-100 bg-white">
                <span>注文履歴</span>
            </a>
        </ul>
        {{-- main contents --}}
        <div class="px-5 py-20 mx-auto w-5/6">
            @yield('content')
        </div>
    </div>

    <script src="{{ App\consts\CommonConst::JS_PATH }}header_menu.js"></script>
    @stack('js')
</body>

</html>
