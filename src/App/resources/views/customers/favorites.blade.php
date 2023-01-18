@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold mb-8">お気に入り一覧</h2>
        <ul class="px-4 flex flex-wrap">
            @if ($favorites !== false)
                @foreach ($favorites as $item)
                    <li class="mb-8">
                        <a href="/product?id={{ $item['product_id'] }}" class="flex flex-col items-center hover:opacity-80">
                            <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $item['image'] }}"
                                alt="{{ $product['image'] }}" class="w-[200px] mr-4">
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
