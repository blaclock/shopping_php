@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-3xl font-bold mb-8">ショッピングカート</h2>
        @if ($carts !== false)
            <ul class="p-8 bg-white">
                <form action="/mypage/orders/store" method="post">
                    <input type="hidden" name="token" value="{{ $token }}">
                    @foreach ($carts as $item)
                        <li class="flex py-4 border-t-2 border-gray-200">
                            <a href="/product?id={{ $item['product_id'] }}" class="hover:opacity-80">
                                <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $item['image'] }}"
                                    alt="{{ $item['name'] }}" class="w-[200px] mr-4">
                            </a>
                            <div class="flex flex-col">
                                <a href="/product?id={{ $item['product_id'] }}" class="inline-block mb-2 hover:opacity-80">
                                    <span class="text-2xl">{{ $item['name'] }}</span>
                                </a>
                                <span class="mb-1">&yen;{{ number_format($item['price']) }}</span>
                                <span class="mb-1">数量：{{ $item['num'] }}個</span>
                                <span
                                    class="mb-2 font-medium">小計：&yen;{{ number_format($item['price'] * $item['num']) }}</span>
                                <a href="/cart/delete?cart_id={{ $item['id'] }}"
                                    class="w-12 text-center rounded-full border border-gray-500  bg-gray-700 text-white hover:opacity-80">削除</a>
                            </div>
                        </li>
                        <input type="hidden" name="cart_id[]" value="{{ $item['id'] }}">
                        <input type="hidden" name="product_id[]" value="{{ $item['product_id'] }}">
                        <input type="hidden" name="quantity[]" value="{{ $item['num'] }}">
                    @endforeach
                    <li class="py-4 border-t-2 border-gray-200 text-right text-2xl">
                        <p>合計({{ $totalQuantity }}個の商品)</p>
                        <p>&yen;{{ number_format($totalAmount) }}(税込)</p>
                        <input type="submit" value="購入する"
                            class="rounded-full border border-gray-500 w-[200px] px-2 py-2 bg-gray-700 text-white hover:cursor-pointer hover:opacity-80">
                    </li>
                </form>
            </ul>
        @else
            <p>カートに商品はありません。</p>
        @endif

    </section>
@endsection
