@extends('layouts.admin.app')

@section('content')
    <section class="text-gray-600 body-font">
        <div class="">
            <div class="flex items-center mb-5">
                <h2 class="inline-block mr-4 text-3xl">商品一覧</h2>
                <a href="{{ App\consts\CommonConst::APP_URL }}admin/product/register"
                    class="inline-block text-center py-2 bg-white w-[100px] border border-gray-300 hover:bg-gray-700 hover:text-white duration-200">
                    <span>新規登録</span>
                </a>
            </div>
            @if ($products)
                <p class="">{{ $productNum }}件</p>
                <ul class="mb-10">
                    @foreach ($products as $product)
                        <li class="border border-gray-100 mb-5">
                            <div class="flex bg-gray-100 px-5 py-5">
                                <span class="mr-10">登録日：<br>{{ explode(' ', $product['created_at'])[0] }}</span>
                                @if (isset($product['updated_at'][0]))
                                    <span class="mr-10">最終更新日：<br>{{ explode(' ', $product['updated_at'])[0] }}</span>
                                @endif
                            </div>
                            <div class="flex px-5 py-4 border-t-2 border-gray-200 bg-white">
                                <div class="w-[100px] mr-5">
                                    <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $product['image'] }}"
                                        alt="{{ $product['name'] }}" class="w-full">
                                </div>
                                <div class="flex flex-col w-[calc(100%_-_120px)]">
                                    <span class="mb-2">商品名：{{ $product['name'] }}</span>
                                    <span class="mb-2">カテゴリー：{{ $product['category'] }}</span>
                                    <span class="mb-4">価格：&yen;{{ number_format($product['price']) }}円</span>
                                    <div class="mt-2">
                                        <a href="/admin/product/edit/?id={{ $product['id'] }}"
                                            class="hover:opacity-70">編集する</a>
                                        <a href="/admin/product/delete?id={{ $product['id'] }}"
                                            class="hover:opacity-70">削除する</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @if ($pagination['pageNum'] > 1)
                    {{-- @include('components.pagination') --}}
                    @component('components.pagination', ['pageUrl' => '/admin/products?'])
                    @endcomponent
                @endif
            @else
                <p class="">検索に一致する商品は見つかりませんでした。</p>
            @endif
        </div>
    </section>
@endsection
