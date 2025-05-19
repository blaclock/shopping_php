@extends('layouts.admin.app')

@section('content')
    <div class="">
        <ul class="mb-4 md:mb-8">
            <li class="flex mb-4">
                <span class="w-[200px] text-lg">商品名</span>
                <span>{{ $productData['name'] }}</span>
            </li>
            <li class="flex mb-4">
                <span class="w-[200px] text-lg">価格(税込)</span>
                <span>{{ number_format($productData['price']) }}円</span>
            </li>
            <li class="flex mb-4">
                <span class="w-[200px] text-lg">画像</span>
                <div>
                    @if (!empty($productData['image']['name']))
                        <img src="{{ \App\consts\CommonConst::IMG_PATH }}products/{{ $productData['image']['name'] }}"
                            alt="{{ $productData['image']['name'] }}" class="w-[200px] mb-2">
                    @else
                        <img src="{{ \App\consts\CommonConst::IMG_PATH }}products/{{ $productData['presentImage'] }}"
                            alt="{{ $productData['presentImage'] }}" class="w-[200px] mb-2">
                    @endif
                </div>
            </li>
            <li class="flex">
                <span class="w-[200px] text-lg">カテゴリー</span>
                <span>{{ $categories[$productData['category_id'] - 1]['name'] }}</span>
            </li>
            <li class="flex mb-4">
                <span class="w-[200px] text-lg">説明</span>
                <div>
                    <span>{{ $productData['detail'] }}</span>
                </div>
            </li>
        </ul>

        <form action="/admin/product/update" method="POST">
            @foreach ($productData as $key => $val)
                @if ($key === 'image')
                    <input type="hidden" name="{{ $key }}"value="{{ $val['name'] }}">
                @else
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endif
            @endforeach
            @if (empty($productData['image']['name']))
                <input type="hidden" name="image" value="{{ $productData['presentImage'] }}">
            @endif
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="submit" name="send"
                class="rounded-full border border-gray-500 w-32 px-6 py-4 mr-4 bg-white hover:bg-gray-700 hover:text-white hover:cursor-pointer"
                value="戻る">
            <input type="submit" name="send"
                class="rounded-full border border-gray-500 w-32 px-6 py-4 bg-white hover:bg-red-700 hover:text-white"
                value="{{ APP\consts\CommonConst::UPDATE_COMPLETE }}">
        </form>
    </div>
@endsection
