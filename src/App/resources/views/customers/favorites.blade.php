@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold mb-8">お気に入り一覧</h2>
        <ul class="flex flex-wrap justify-between">
            @if ($favorites !== false)
                @foreach ($favorites as $item)
                    <li
                        class="px-2 md:px-5 w-6/12 md:w-1/3 lg:w-1/4 [&:nth-child(n+3)]:mt-5 md:[&:nth-child(n+4)]:mt-5 md:[&:nth-child(-n+3)]:mt-0 lg:[&:nth-child(n+5)]:mt-5 lg:[&:nth-child(-n+4)]:mt-0">
                        <a href="/product?id={{ $item['product_id'] }}" class="flex flex-col items-center hover:opacity-80">
                            <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $item['image'] }}"
                                alt="{{ $product['image'] }}" class="">
                            <span>{{ $item['name'] }}</span>
                        </a>
                    </li>
                @endforeach
            @else
                <p>お気に入りに登録された商品はありません。</p>
            @endif
        </ul>
    </section>
@endsection
