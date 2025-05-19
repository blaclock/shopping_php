@extends('layouts.admin.app')

@section('content')
    <div>
        <form method="post" action="/admin/product/confirm" enctype="multipart/form-data">
            {{-- 二重登録防止のトークン --}}
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="flex mb-4">
                <p class="w-[200px] text-lg">商品名</p>
                <p>{{ $productData['name'] }}</p>
            </div>
            <div class="flex mb-4">
                <p class="w-[200px] text-lg">価格(税込)</p>
                <p>{{ number_format($productData['price']) }}円</p>
            </div>
            <div class="flex mb-4">
                <label for="image" class="w-[200px] text-lg">画像</label>
                <img src="{{ \App\consts\CommonConst::IMG_PATH }}products/{{ $productData['image']['name'] }}"
                    alt="{{ $productData['image']['name'] }}" class="w-[200px]">
            </div>
            <div class="flex mb-4">
                <p class="w-[200px] text-lg">カテゴリー</p>
                <p>{{ $categories[$productData['category'] - 1]['name'] }}</p>
            </div>
            <div class="flex mb-8">
                <p class="w-[200px] text-lg">説明</p>
                <p>{{ $productData['detail'] }}</p>
            </div>
            <div class="flex mb-4">
                <input type="submit" name="send" value="{{ \App\consts\CommonConst::REGISTER_BACK }}"
                    class="rounded-full border border-gray-500 w-32 bg-white hover:bg-gray-700 hover:text-white px-4 md:px-6 py-2 md:py-4 hover:cursor-pointer mr-5">
                <input type="submit" name="send" value="{{ \App\consts\CommonConst::REGISTER_COMPLETE }}"
                    class="rounded-full border border-gray-500 w-32 bg-white hover:bg-red-700 hover:text-white px-4 md:px-6 py-2 md:py-4 hover:cursor-pointer">
            </div>
            @foreach ($productData as $column => $val)
                @if ($column === 'image')
                    <input type="hidden" name="{{ $column }}" value="{{ $val['name'] }}">
                @else
                    <input type="hidden" name="{{ $column }}" value="{{ $val }}">
                @endif
            @endforeach
        </form>
    </div>
    <script>
        history.replaceState(null, '');
    </script>
@endsection
