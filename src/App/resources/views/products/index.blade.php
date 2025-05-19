@extends('layouts.app')

@push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}displayDropArea.js"></script>
@endpush

@section('content')
    <section class="text-gray-600 body-font mb-10">
        <div>
            <div class="flex items-center relative w-full">
                <span class="text-lg">{{ $productNum }}件</span>
                @component('components.filter')
                @endcomponent
                <div class="inline-block ml-auto filter">
                    <span class="inline-block ml-auto text-lg text-right px-2 py-2 hover:cursor-pointer">↑↓並べ替え</span>
                    <div class="absolute top-full right-0 bg-gray-300 flex-col z-10 hidden dropArea">
                        <a href="/products?{{ $sortQuery }}&sort=created_at_DESC"
                            class="px-5 py-2 hover:bg-gray-200"><span>新着順</span></a>
                        <a href="/products?{{ $sortQuery }}&sort=price_ASC"
                            class="px-5 py-2 hover:bg-gray-200"><span>価格の安い順</span></a>
                        <a href="/products?{{ $sortQuery }}&sort=price_DESC"
                            class="px-5 py-2 hover:bg-gray-200"><span>価格の高い順</span></a>
                        <a href="/products?{{ $sortQuery }}&sort=likes_DESC"
                            class="px-5 py-2 hover:bg-gray-200"><span>お気に入り登録の多い順</span></a>
                        <a href="/products?{{ $sortQuery }}&sort=score_DESC"
                            class="px-5 py-2 hover:bg-gray-200"><span>レビュー評価の高い順</span></a>
                        <a href="/products?{{ $sortQuery }}&sort=reviews_DESC"
                            class="px-5 py-2 hover:bg-gray-200"><span>レビュー件数の多い順</span></a>
                    </div>
                </div>
            </div>
            @if ($products)
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
                <p class="text-2xl mt-10">検索に一致する商品は見つかりませんでした。</p>
            @endif
        </div>
    </section>
    @if ($pagination['pageNum'] > 1)
        @component('components.pagination', ['pageUrl' => '/products?'])
        @endcomponent
    @endif
@endsection
