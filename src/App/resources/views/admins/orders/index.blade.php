@extends('layouts.admin.app')

@push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}displayDropArea.js"></script>
@endpush

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-3xl font-bold mb-8">注文履歴</h2>
        @if ($orders !== false)
            <div class="flex mb-2 relative ">
                <span class="">{{ $orderNum }}件</span>
                <div class="inline-block ml-auto filter">
                    <span class="inline-block ml-auto text-lg text-right pb-2">↑↓フィルター</span>
                    <div class="absolute left-0 hidden dropArea w-full">
                        @if (isset($_GET['category_id']))
                            <form action="/admin/orders" method="get" class="p-8 w-full bg-gray-300">
                                <input type="hidden" name="category_id" value="{{ $_GET['category_id'] }}">
                            @else
                                <form action="/admin/orders" method="get" class="p-8 w-full bg-gray-300">
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
            </div>
            <ul class="mb-10">
                @foreach ($orders as $order)
                    <li class="border border-gray-100 bg-white mb-5">
                        <div class="flex flex-col md:flex-row bg-gray-100 px-5 py-5">
                            <span class="mr-10">注文日：<br
                                    class="hidden md:inline">{{ explode(' ', $order['created_at'])[0] }}</span>
                            <span class="mr-10">金額：<br
                                    class="hidden md:inline">&yen;{{ number_format($order['price'] * $order['quantity']) }}</span>
                            <a href="/admin/customers?id={{ $order['customer_id'] }}"><span class="">注文者：<br
                                        class="hidden md:inline">{{ $order['family_name'] . ' ' . $order['first_name'] }}</span></a>
                            <span class="md:ml-auto">注文ID：{{ $order['id'] }}</span>
                        </div>
                        <div class="flex px-5 py-4 border-t-2 border-gray-200">
                            <a href="/product?id={{ $order['product_id'] }}" class="hover:opacity-80">
                                <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $order['image'] }}"
                                    alt="{{ $order['name'] }}" class="w-[100px] mr-4">
                            </a>
                            <div class="flex flex-col">
                                <span class="mb-2">商品名：{{ $order['name'] }}</span>
                                <span class="mr-5">数量：{{ $order['quantity'] }}</span>

                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            @if ($pagination['pageNum'] > 1)
                {{-- @include('components.pagination') --}}
                @component('components.pagination', ['pageUrl' => '/admin/orders?'])
                @endcomponent
            @endif
        @else
            <p class="">注文が登録されていません。</p>
        @endif
    </section>
@endsection
