@extends('layouts.app')

@push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}updateCart.js"></script>
@endpush

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-3xl font-bold mb-8">ショッピングカート</h2>
        @if ($carts !== false)
            <ul class="p-8 bg-white">
                <form action="/mypage/orders/confirm" method="post">
                    <input type="hidden" name="token" value="{{ $token }}">
                    @foreach ($carts as $item)
                        <li class="flex py-4 border-t-2 border-gray-200 cart-info">
                            <a href="/product?id={{ $item['product_id'] }}" class="hover:opacity-80">
                                <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $item['image'] }}"
                                    alt="{{ $item['name'] }}" class="w-[200px] mr-4">
                            </a>
                            <div class="flex flex-col">
                                <a href="/product?id={{ $item['product_id'] }}" class="inline-block mb-2 hover:opacity-80">
                                    <span class="text-lg md:text-2xl">{{ $item['name'] }}</span>
                                </a>
                                <div class="flex items-center">
                                    <label for="quantity" class="mr-4">数量</label>
                                    <select name="quantity[]" id="quauntity"
                                        class="quantity border border-gray-600 px-2 py-2 mr-4">
                                        @for ($i = 0; $i <= 10; $i++)
                                            <option value="{{ $i }}"
                                                @if ($i === $item['quantity']) selected @endif>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <span
                                    class="mb-4 font-medium">小計：&yen;{{ number_format($item['price'] * $item['quantity']) }}</span>
                                <p>
                                    <a href="/cart/delete?cart_id={{ $item['id'] }}"
                                        class="px-4 py-2 text-center rounded-lg border border-gray-500  bg-gray-700 text-white hover:opacity-80">削除</a>
                                </p>
                            </div>
                        </li>
                        <input type="hidden" name="cart_id[]" value="{{ $item['id'] }}">
                        <input type="hidden" name="product_id[]" value="{{ $item['product_id'] }}">
                    @endforeach
                    <li class="py-4 border-t-2 border-gray-200 text-right text-2xl">
                        <p>合計({{ $totalQuantity }}個の商品)</p>
                        <p class="mb-2 md:mb-5">&yen;{{ number_format($totalAmount) }}(税込)</p>
                        <input type="submit" value="注文する"
                            class="rounded-full border border-gray-500 px-5 md:px-10 py-2 md:py-4 bg-gray-700 text-white hover:cursor-pointer hover:opacity-80">
                    </li>
                </form>
            </ul>
        @else
            <p>カートに商品はありません。</p>
        @endif

    </section>
@endsection
