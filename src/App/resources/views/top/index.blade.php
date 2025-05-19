<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"content="IE=edge">
    <meta name="viewport"content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="stylesheet"href="{{ App\consts\CommonConst::CSS_PATH }}output.css">
    <link rel="stylesheet"href="{{ App\consts\CommonConst::CSS_PATH }}style.css">
    <link rel="stylesheet"href="{{ App\consts\CommonConst::CSS_PATH }}header_menu.css">
    <link rel="stylesheet"href="{{ App\consts\CommonConst::CSS_PATH }}top_mv.css">
    @stack('css')
    <title>醸-KAMOSU トップページ</title>
</head>

<body class="bg-gray-50">
    @component('components.header', [
        'headerBgColor' => 'white',
        'headerBgColorSp' => 'gray-700',
        'headerTextColor' => 'gray-600',
        'headerTextColorSp' => 'white',
        'user' => 'customer',
    ])
    @endcomponent

    <main class="min-h-screen">
        <section class="MV md:mt-[80px]">
            <!-- Slider main container -->
            <div class="swiper mv mt-5 md:mt-0 mb-10 md:mb-20">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <a href="/products?category_id=1" class="swiper-slide hover:opacity-80">
                        <img src="{{ App\consts\CommonConst::IMG_PATH }}/top/mv_sake.jpg" alt="日本酒"
                            class="w-full hidden md:block">
                        <img src="{{ App\consts\CommonConst::IMG_PATH }}/top/mv_sake_sp.jpg" alt="日本酒"
                            class="w-full block md:hidden">
                        <div
                            class="absolute left-1/10 top-1/2 -translate-y-1/2 text-white text-2xl sm:text-4xl md:text-6xl">
                            <p class="mb-5 md:mb-10 drop-shadow-lg shadow-black">日本酒との<br>新しい出逢いを</p>
                            <p
                                class="inline-block rounded-sm text-gray-600 text-base me:text-xl px-4 md:px-10 py-2 md:py-5 bg-gray-200">
                                詳しく見る
                            </p>
                        </div>
                    </a>
                    <a href="/products?category_id=2" class="swiper-slide hover:opacity-80">
                        <img src="{{ App\consts\CommonConst::IMG_PATH }}/top/mv_beer.jpg" alt="ビール"
                            class="w-full hidden md:block">
                        <img src="{{ App\consts\CommonConst::IMG_PATH }}/top/mv_beer_sp.jpg" alt="ビール"
                            class="w-full block md:hidden">
                        <div
                            class="absolute left-1/10 top-1/2 -translate-y-1/2 text-white text-2xl sm:text-4xl md:text-6xl">
                            <p class="mb-5 md:mb-10 drop-shadow-lg shadow-black">クラフトビールで<br>少し贅沢なおうち時間を</p>
                            <p
                                class="inline-block rounded-sm text-gray-600 text-base me:text-xl px-4 md:px-10 py-2 md:py-5 bg-gray-200">
                                詳しく見る
                            </p>
                        </div>
                    </a>
                    <a href="/products?category_id=3" class="swiper-slide hover:opacity-80">
                        <img src="{{ App\consts\CommonConst::IMG_PATH }}/top/mv_wine.jpg" alt="ワイン"
                            class="w-full hidden md:block">
                        <img src="{{ App\consts\CommonConst::IMG_PATH }}/top/mv_wine_sp.jpg" alt="ワイン"
                            class="w-full block md:hidden">
                        <div
                            class="absolute left-1/10 top-1/2 -translate-y-1/2 text-white text-2xl sm:text-4xl md:text-6xl">
                            <p class="mb-5 md:mb-10 drop-shadow-lg shadow-black">ワインとあなたの<br>素敵なマリアージュを</p>
                            <p
                                class="inline-block rounded-sm text-gray-600 text-base me:text-xl px-4 md:px-10 py-2 md:py-5 bg-gray-200">
                                詳しく見る</p>
                        </div>
                    </a>
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </section>

        <section class="pl-5 md:pl-[200px] mb-20">
            <h2 class="text-xl md:text-2xl mb-5 font-medium">人気商品</h2>
            <ul class="swiper hot-items relative">
                <div class="swiper-wrapper">
                    @foreach ($top5 as $key => $item)
                        <li class="swiper-slide relative">
                            {{-- class="swiper-slide relative overflow-hidden before:absolute before:border-solid before:border-b-0 before:border-r-0 before:border-t-8  before:border-l-8 border-red-400"> --}}
                            <a href="/product?id={{ $item['id'] }}" class="hover:opacity-80">
                                <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $item['image'] }}"
                                    alt="" class="">
                            </a>
                            <div class="absolute top-0 left-2 text-white z-10">
                                {{ $key + 1 }}</div>
                            <div class="w-11  overflow-hidden inline-block absolute top-0 left-0">
                                <div class=" h-16  bg-gray-700 rotate-45 transform origin-top-right"></div>
                            </div>
                        </li>
                    @endforeach
                </div>
                <!-- If we need navigation buttons -->
                {{-- <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div> --}}
            </ul>
        </section>
    </main>

    @component('components.footer', [
        'footerBgColor' => 'white',
        'footerTextColor' => 'gray-600',
        'user' => 'customer',
    ])
    @endcomponent
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="{{ App\consts\CommonConst::JS_PATH }}top_mv.js"></script>
</body>

</html>
