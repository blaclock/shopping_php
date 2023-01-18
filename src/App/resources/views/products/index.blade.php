@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <div>
            @if ($products)
                <ul class="flex flex-wrap -m-4">
                    @foreach ($products as $product)
                        <li class="lg:w-1/4 md:w-1/2 p-4 w-full">
                            <a href="{{ App\consts\CommonConst::APP_URL }}product?id={{ $product['id'] }}"
                                class="hover:opacity-90">
                                <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $product['image'] }}"
                                    alt="{{ $product['image'] }}">
                                <p class="product-name">{{ $product['name'] }}</p>
                                <div>
                                    <span>{{ $product['category'] }}</span>
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
        @include('components.pagination')
    @endif
@endsection
