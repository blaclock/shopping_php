@extends('layouts.app')

@push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}displayDropArea.js"></script>
@endpush

@section('content')
    <section class="text-gray-600 body-font mb-10">
        <div>
            @if ($products)
                <div class="flex relative w-full">
                    <span class="text-lg">{{ $productNum }}件</span>
                    <div class="inline-block ml-5 filter">
                        <span class="inline-block ml-auto text-lg text-right pb-2">↑↓フィルター</span>
                        <div class="absolute left-0 hidden dropArea w-full">
                            @if (isset($_GET['category_id']))
                                <form action="/products" method="get" class="p-8 w-full bg-gray-300">
                                    <input type="hidden" name="category_id" value="{{ $_GET['category_id'] }}">
                                @else
                                    <form action="/products" method="get" class="p-8 w-full bg-gray-300">
                            @endif
                            <div class="flex flex-col md:flex-row mb-4">
                                <span class="text-xl mr-4">期間</span>
                                <input type="date" name="period_beginning">〜
                                <input type="date" name="period_ending">
                            </div>
                            <div class="text-right">
                                <input type="submit" value="絞り込み"
                                    class="rounded-full border border-gray-500 w-[200px] px-4 py-4 bg-white hover:bg-gray-700 hover:text-white hover:cursor-pointer duration-200">
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="inline-block ml-auto filter">
                        <span class="inline-block ml-auto text-lg text-right pb-2">↑↓並べ替え</span>
                        <div class="absolute top-full right-0 bg-gray-300 flex-col z-10 hidden dropArea">
                            @if (isset($_GET['category_id']))
                                <a href="/products?category_id={{ $_GET['category_id'] }}&sort=created_at_DESC"
                                    class="px-5 py-2 hover:bg-gray-200"><span>新着順</span></a>
                                <a href="/products?category_id={{ $_GET['category_id'] }}&sort=price_ASC"
                                    class="px-5 py-2 hover:bg-gray-200"><span>価格の安い順</span></a>
                                <a href="/products?category_id={{ $_GET['category_id'] }}&sort=price_DESC"
                                    class="px-5 py-2 hover:bg-gray-200"><span>価格の高い順</span></a>
                                <a href="/products?category_id={{ $_GET['category_id'] }}&sort=likes_DESC"
                                    class="px-5 py-2 hover:bg-gray-200"><span>お気に入り登録の多い順</span></a>
                                <a href="/products?category_id={{ $_GET['category_id'] }}&sort=score_DESC"
                                    class="px-5 py-2 hover:bg-gray-200"><span>レビュー評価の高い順</span></a>
                                <a href="/products?category_id={{ $_GET['category_id'] }}&sort=reviews_DESC"
                                    class="px-5 py-2 hover:bg-gray-200"><span>レビュー件数の多い順</span></a>
                            @else
                                <a href="/products?sort=created_at_DESC"
                                    class="px-5 py-2 hover:bg-gray-200"><span>新着順</span></a>
                                <a href="/products?sort=price_ASC"
                                    class="px-5 py-2 hover:bg-gray-200"><span>価格の安い順</span></a>
                                <a href="/products?sort=price_DESC"
                                    class="px-5 py-2 hover:bg-gray-200"><span>価格の高い順</span></a>
                                <a href="/products?sort=likes_DESC"
                                    class="px-5 py-2 hover:bg-gray-200"><span>お気に入り登録の多い順</span></a>
                                <a href="/products?sort=score_DESC"
                                    class="px-5 py-2 hover:bg-gray-200"><span>レビュー評価の高い順</span></a>
                                <a href="/products?sort=reviews_DESC"
                                    class="px-5 py-2 hover:bg-gray-200"><span>レビュー件数の多い順</span></a>
                            @endif
                        </div>
                    </div>
                </div>
                <ul class="flex flex-wrap -m-4">
                    @foreach ($products as $product)
                        <li class="lg:w-1/4 md:w-1/2 p-4 w-1/2">
                            <a href="{{ App\consts\CommonConst::APP_URL }}product?id={{ $product['id'] }}"
                                class="hover:opacity-90">
                                <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $product['image'] }}"
                                    alt="{{ $product['image'] }}">
                                <p class="">{{ $product['name'] }}</p>
                                <div>
                                    <p class="flex items-center">
                                        @component('components.score', ['type' => 'average', 'score' => $product['score']])
                                        @endcomponent
                                        <span class="text-lg ml-1">{{ $product['reviews'] }}</span>
                                    </p>
                                    <span>&yen;{{ number_format($product['price']) }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>検索に一致する商品は見つかりませんでした。</p>
            @endif
        </div>
    </section>
    @if ($pagination['pageNum'] > 1)
        @component('components.pagination', ['pageUrl' => '/products?'])
        @endcomponent
    @endif
@endsection
