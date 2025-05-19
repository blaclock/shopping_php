<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"content="IE=edge">
    <meta name="viewport"content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <link rel="stylesheet"href="{{ App\consts\CommonConst::CSS_PATH }}output.css">
    <link rel="stylesheet"href="{{ App\consts\CommonConst::CSS_PATH }}style.css">
    <link rel="stylesheet"href="{{ App\consts\CommonConst::CSS_PATH }}header_menu.css">
    @stack('css')
    <title>Document</title>
</head>

<body>
    @component('components.header', [
        'headerBgColor' => 'gray-700',
        'headerBgColorSp' => 'gray-700',
        'headerTextColor' => 'white',
        'headerTextColorSp' => 'white',
        'user' => 'admin',
    ])
    @endcomponent

    <div class="flex bg-gray-50 min-h-screen">
        {{-- sidebar --}}
        <ul class="sidebar hidden w-[200px] md:flex flex-col bg-gray-700">
            <a href="{{ App\consts\CommonConst::APP_URL }}admin" class="p-4 text-white hover:bg-gray-600">
                <span>トップ</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/admins" class="p-4 text-white hover:bg-gray-600">
                <span>管理者情報</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/customers/top" class="p-4 text-white hover:bg-gray-600">
                <span>顧客管理</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/products/top" class="p-4 text-white hover:bg-gray-600">
                <span>商品管理</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/orders/top" class="p-4 text-white hover:bg-gray-600">
                <span>注文履歴</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/contacts" class="p-4 text-white hover:bg-gray-600">
                <span>お問い合わせ</span>
            </a>
        </ul>
        {{-- main contents --}}
        <div class="max-w-[1920px] px-5 md:px-10 py-10 md:py-20 w-full md:w-[calc(100%_-_200px)]">
            @yield('content')
        </div>
    </div>

    @component('components.footer', [
        'footerBgColor' => 'gray-700',
        'footerTextColor' => 'white',
        'user' => 'admin',
    ])
    @endcomponent
</body>

</html>
