@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold mb-4">この商品をレビュー</h2>
        <div class="flex items-center mb-8">
            <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $product['image'] }}" alt="{{ $product['image'] }}"
                class="w-20">
            <span class="ml-4">{{ $product['name'] }}</span>
        </div>
        <ul class="px-4 mb-6">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <li class="flex flex-col items-center md:flex-row mb-4">
                <label for="title" class="w-[200px] text-lg">レビュータイトル</label>
                <input type="text" name="title" id="title" value="{{ $customer['title'] }}"
                    class="lg:w-[700px] border border-gray-300 p-2">
            </li>
            <li class="flex flex-col items-center md:flex-row mb-4">
                <label for="content" class="w-[200px] text-lg">レビューを追加</label>
                <textarea name="content" id="content" class="border border-gray-300 p-2 w-[700px] h-[130px]">{{ $customer['content'] }}</textarea>
            </li>
        </ul>
        <form action="/products?id={{ $product['id'] }}">
            <input type="submit" name="send"
                class="rounded-full border border-gray-500 w-32 bg-white hover:bg-gray-700 hover:text-white px-6 py-4 hover:cursor-pointer"
                value="投稿">
        </form>
    </section>
@endsection
