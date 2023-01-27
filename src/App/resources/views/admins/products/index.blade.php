@extends('layouts.admin.app')

@section('content')
    <section class="text-gray-600 body-font">
        <div class="w-11/12 mx-auto">
            <div class="w-[200px]">
                <a href="{{ App\consts\CommonConst::APP_URL }}admin/product/register"
                    class="inline-block text-center py-2 mb-5 bg-white w-[100px] border border-gray-300 hover:bg-gray-100">
                    <span>新規登録</span>
                </a>
            </div>
            @if ($products)
                <ul class="">
                    @foreach ($products as $product)
                        <li class="p-4 mb-10 bg-white flex">
                            <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $product['image'] }}"
                                alt="{{ $product['image'] }}" class="w-[100px]">
                            <div class="w-5/6 pl-5">
                                <span class="text-2xl">{{ $product['name'] }}</span>
                                <div class="mt-2">
                                    <a href="/admin/product?id={{ $product['id'] }}/edit" class="hover:opacity-70">編集する</a>
                                    <a href="/admin/product/delete?id={{ $product['id'] }}"
                                        class="hover:opacity-70">削除する</a>
                                </div>
                            </div>
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
