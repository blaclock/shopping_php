@extends('layouts.app')

@push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}updateCart.js"></script>
    <script src="{{ App\consts\CommonConst::JS_PATH }}postcode.js"></script>
@endpush

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-3xl font-bold mb-8">購入確認</h2>
        @if ($carts !== false)
            <ul class="px-2 py-4 md:p-8 bg-white">
                <form action="/mypage/orders/checkout" method="post">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="flex flex-col md:flex-row border-t-2 border-gray-200 py-4 md:py-10">
                        <span class="w-1/4 mb-4 md:mb-0 text-xl md:text-2xl">受取場所</span>
                        <div class="w-full md:w-3/4 flex flex-col">
                            <span class="mb-2">{{ $customer['family_name'] . ' ' . $customer['first_name'] }}</span>
                            <div class="flex flex-col md:flex-row">
                                <label for="zip" class="w-[100px]">郵便番号</label>
                                <div class="">
                                    <input type="text" name='zip' value="{{ $customer['zip'] }}"
                                        class="w-1/2 border border-gray-700 px-2 py-1 mb-2" id="zip">
                                    <span
                                        class="inline-block px-2 py-1 mb-2 md:mb-0 md:ml-2 border border-gray-700 bg-gray-700 text-white"
                                        id="postcodeBtn">住所検索</span>
                                </div>
                            </div>
                            @if (isset($errMessage['zip']))
                                @foreach ($errMessage['zip'] as $error)
                                    <p class="text-red-400">{{ $error }}</p>
                                @endforeach
                            @endif
                            <div class="flex flex-col md:flex-row">
                                <label for="address" class="w-[100px]">住所</label>
                                <input type="text" name='delivery_to' value="{{ $customer['address'] }}"
                                    class="w-full md:w-1/2 border border-gray-700 px-2 py-1" id="address">
                            </div>
                            @if (isset($errMessage['delivery_to']))
                                @foreach ($errMessage['delivery_to'] as $error)
                                    <p class="text-red-400">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row border-t-2 border-gray-200 py-4 md:py-10">
                        <span class="w-1/4 mb-4 md:mb-0 text-xl md:text-2xl">決済方法</span>
                        <div class="w-full md:w-3/4">
                            <div class="flex">
                                <div class="mr-5">
                                    <input type="radio" name='payment_type' value="credit" id="credit" class="">
                                    <label for="credit">クレジット</label>
                                </div>
                                <div class="">
                                    <input type="radio" name='payment_type' value="cash" id="cash" class="">
                                    <label for="cash">現金</label>
                                </div>
                            </div>
                            @if (isset($errMessage['payment_type']))
                                @foreach ($errMessage['payment_type'] as $error)
                                    <p class="text-red-400">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row border-t-2 border-gray-200 py-4 md:py-10">
                        <span class="md:w-1/4 mb-4 md:mb-0 text-xl md:text-2xl">商品情報</span>
                        <div class="w-full md:w-3/4">
                            @foreach ($carts as $item)
                                <li class="flex p-4 cart-info border border-gray-300 rounded-lg mb-5 md:mb-10">
                                    <a href="/product?id={{ $item['product_id'] }}" class="hover:opacity-80">
                                        <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $item['image'] }}"
                                            alt="{{ $item['name'] }}" class="w-[200px] mr-4">
                                    </a>
                                    <div class="flex flex-col">
                                        <a href="/product?id={{ $item['product_id'] }}"
                                            class="inline-block mb-4 hover:opacity-80">
                                            <span class="text-lg md:text-2xl">{{ $item['name'] }}</span>
                                        </a>
                                        <span class="mb-2 font-medium">数量：{{ $item['quantity'] }}</span>
                                        <span
                                            class="font-medium">小計：&yen;{{ number_format($item['price'] * $item['quantity']) }}</span>
                                    </div>
                                </li>
                                <input type="hidden" name="cart_id[]" value="{{ $item['id'] }}">
                                <input type="hidden" name="product_id[]" value="{{ $item['product_id'] }}">
                                <input type="hidden" name="quantity[]" value="{{ $item['quantity'] }}">
                            @endforeach
                        </div>
                    </div>
                    <div class="py-4 border-t-2 border-gray-200 text-right md:text-2xl">
                        <p>合計({{ $totalQuantity }}個の商品)</p>
                        <p class="mb-2 md:mb-5">&yen;{{ number_format($totalAmount) }}(税込)</p>
                        <input type="submit" value="注文を確定"
                            class="rounded-full border border-gray-500 px-5 md:px-10 py-2 md:py-4 bg-gray-700 text-white hover:cursor-pointer hover:opacity-80">
                    </div>
                </form>
            </ul>
        @else
            <p>カートに商品はありません。</p>
        @endif

    </section>
@endsection
