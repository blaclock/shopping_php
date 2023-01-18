@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-3xl font-bold mb-8">注文履歴</h2>
        @if ($orders !== false)
            <ul class="p-8 bg-white">
                @foreach ($orders as $order)
                    <li class="flex py-4 border-t-2 border-gray-200">
                        <a href="/product?id={{ $order['product_id'] }}" class="hover:opacity-80">
                            <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $order['image'] }}"
                                alt="{{ $order['name'] }}" class="w-[200px] mr-4">
                        </a>
                        <div class="flex flex-col">
                            <span class="mb-2">注文日：{{ $order['created_at'] }}</span>
                            <a href="/product?id={{ $order['product_id'] }}" class="inline-block mb-2 hover:opacity-80">
                                <span class="text-2xl">{{ $order['name'] }}</span>
                            </a>
                            <span class="mb-1">&yen;{{ number_format($order['price']) }}</span>
                            <span class="mb-1">数量：{{ $order['quantity'] }}個</span>
                            <span
                                class="font-medium">合計：&yen;{{ number_format($order['price'] * $order['quantity']) }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>購入履歴はありません。</p>
        @endif

    </section>
@endsection
