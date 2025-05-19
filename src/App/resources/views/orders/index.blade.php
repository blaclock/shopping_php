@extends('layouts.app')

@push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}displayDropArea.js"></script>
@endpush

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold">注文履歴</h2>

        <div class="flex items-center mb-2 relative ">
            <span class="text-lg">{{ $orderNum }}件</span>
            <div class="inline-block filter">
                <span class="inline-block ml-auto text-lg text-right pb-2">フィルター</span>
                <div class="absolute left-0 hidden dropArea w-full">
                    @if (isset($_GET['category_id']))
                        <form action="/admin/orders?category_id={{ $_GET['category_id'] }}" method="get"
                            class="p-8 w-full bg-gray-300">
                            <input type="hidden" name="category_id" value="{{ $_GET['category_id'] }}">
                        @else
                            <form action="/admin/orders" method="get" class="p-8 w-full bg-gray-300">
                    @endif
                    <div class="flex flex-col md:flex-row mb-5 md:mb-10">
                        <span class="text-xl mr-4">期間</span>
                        <input type="date" name="period_beginning">〜
                        <input type="date" name="period_ending">
                    </div>
                    <div class="text-right">
                        <input type="submit" value="絞り込み"
                            class="rounded-full border border-gray-500 px-2 md:px-4 py-2 md:py-4 bg-white hover:bg-gray-700 hover:text-white hover:cursor-pointer duration-200">
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @if (count($orders) !== 0)
            <ul class="">
                @foreach ($orders as $order)
                    <li class="border border-gray-100 bg-white mb-5">
                        <div class="flex bg-gray-100 px-5 py-5">
                            <span class="mr-10">注文日：<br>{{ explode(' ', $order['created_at'])[0] }}</span>
                            <span class="ml-auto">注文ID：{{ $order['id'] }}</span>
                        </div>
                        <div class="flex px-5 py-4 border-t-2 border-gray-200">
                            <a href="/product?id={{ $order['product_id'] }}" class="hover:opacity-80">
                                <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $order['image'] }}"
                                    alt="{{ $order['name'] }}" class="w-[100px] mr-4">
                            </a>
                            <div class="flex flex-col">
                                <span class="mb-2">商品名：{{ $order['name'] }}</span>
                                <span class="mb-2">数量：{{ $order['quantity'] }}</span>
                                <span
                                    class="mb-4">合計：&yen;{{ number_format($order['price'] * $order['quantity']) }}</span>
                                <a href="/product/review?product_id={{ $order['product_id'] }}"
                                    class="inline-block hover:opacity-70">レビューを書く</a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            @if ($pagination['pageNum'] > 1)
                {{-- @include('components.pagination') --}}
                @component('components.pagination', ['pageUrl' => '/mypage/orders?'])
                @endcomponent
            @endif
        @else
            <p class="mt-8">注文履歴はありません。</p>
        @endif

    </section>
@endsection
