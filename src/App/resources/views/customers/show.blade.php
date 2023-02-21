@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold mb-4">登録情報</h2>
        <ul class="px-4 mb-5 md:mb-10">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <li class="flex flex-col md:flex-row mb-2">
                <span class="w-[200px] text-lg font-semibold">名前</span>
                <span>{{ $customer['family_name'] . ' ' . $customer['first_name'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-2">
                <span class="w-[200px] text-lg font-semibold">メールアドレス</span>
                <span>{{ $customer['email'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-2">
                <span class="w-[200px] text-lg font-semibold">電話番号</span>
                <span>{{ $customer['tel'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-2">
                <span class="w-[200px] text-lg font-semibold">郵便番号</span>
                <span>{{ $customer['zip'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row">
                <span class="w-[200px] text-lg font-semibold">住所</span>
                <span>{{ $customer['address'] }}</span>
            </li>
        </ul>
        <button class="rounded-full border border-gray-500 w-32 bg-white hover:bg-gray-700 hover:text-white mr-[20px]"><a
                href="/mypage/edit" class="px-6 py-4 inline-block">変更する</a></button>
        <button class="rounded-full border border-gray-500 w-32 bg-white hover:bg-red-700 hover:text-white"><a
                href="/mypage/delete" class="px-6 py-4 inline-block">退会する</a></button>
    </section>
@endsection
