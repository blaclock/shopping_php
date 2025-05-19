@extends('layouts.admin.app')

@push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}displayDropArea.js"></script>
@endpush

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-3xl md:text-3xl font-bold mb-5">注文履歴</h2>
        <div class="inline-block px-5 py-2 mb-5 bg-white">
            <p class="text-xl">注文期間：
                @if (empty($_GET['period_beginning']) && empty($_GET['period_ending']))
                    全期間
                @else
                    @if (!empty($_GET['period_beginning']))
                        {{ explode('-', $_GET['period_beginning'])[0] . '年' . explode('-', $_GET['period_beginning'])[1] . '月' . explode('-', $_GET['period_beginning'])[2] . '日' }}
                    @endif
                    〜
                    @if (!empty($_GET['period_ending']))
                        {{ explode('-', $_GET['period_ending'])[0] . '年' . explode('-', $_GET['period_ending'])[1] . '月' . explode('-', $_GET['period_ending'])[2] . '日' }}
                    @endif
                @endif
            </p>
            <p class="text-xl">売上合計金額：{{ number_format($totalAmount) }}</p>
        </div>

        <div class="flex items-center mb-2 relative ">
            <span class="text-lg">{{ $orderNum }}件</span>
            <div class="inline-block ml-5 filter">
                <span class="inline-block text-lg">フィルター</span>
                @if (count($orders) !== 0)
                    <a href="/admin/csv_export/execute?data=Order&period_beginning={{ $_GET['period_beginning'] }}&period_ending={{ $_GET['period_ending'] }}"
                        class="ml-5 inline-block text-center py-2 px-2 bg-white border border-gray-300 hover:bg-gray-700 hover:text-white duration-200">CSVエクスポート</a>
                @endif
                <div class="absolute left-0 hidden dropArea w-full">
                    @if (isset($_GET['category_id']))
                        <form action="/admin/orders" method="get" class="p-8 w-full bg-gray-300">
                            <input type="hidden" name="category_id" value="{{ $_GET['category_id'] }}">
                        @else
                            <form action="/admin/orders" method="get" class="p-8 w-full bg-gray-300">
                    @endif
                    <div class="flex flex-col md:flex-row mb-10">
                        <span class="text-xl mr-4">注文日：</span>
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
            <ul class="mb-10">
                @foreach ($orders as $order)
                    <li class="border border-gray-100 bg-white mb-5">
                        <div class="flex flex-col md:flex-row bg-gray-100 px-2 md:px-5 py-2 md:py-5">
                            <span class="mr-10">注文日：<br
                                    class="hidden md:inline">{{ explode(' ', $order['created_at'])[0] }}</span>
                            <span class="mr-10">金額：<br
                                    class="hidden md:inline">&yen;{{ number_format($order['price'] * $order['quantity']) }}</span>
                            <a href="/admin/customers?id={{ $order['customer_id'] }}"
                                class="hover:opacity-70
                            "><span class="">注文者：<br
                                        class="hidden md:inline">{{ $order['family_name'] . ' ' . $order['first_name'] }}</span></a>
                            <span class="md:ml-auto">注文ID：{{ $order['id'] }}</span>
                        </div>
                        <div class="flex flex-wrap px-2 md:px-5 py-2 md:py-5 border-t-2 border-gray-200">
                            <a href="/product?id={{ $order['product_id'] }}" class="w-[100px] mr-5 hover:opacity-80">
                                <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $order['image'] }}"
                                    alt="{{ $order['name'] }}" class="w-full">
                            </a>
                            <div class="flex flex-col w-[calc(100%_-_120px)]">
                                <span class="mb-2 text-lg">商品名：{{ $order['name'] }}</span>
                                <span class="mr-5">数量：{{ $order['quantity'] }}</span>
                                <span class="mr-5">郵便番号：{{ $order['zip'] }}</span>
                                <span class="mr-5">配達先：{{ $order['delivery_to'] }}</span>
                                <span class="mr-5">決済方法：{{ $order['payment_type'] }}</span>

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
