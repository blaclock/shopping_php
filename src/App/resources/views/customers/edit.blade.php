@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold mb-4">登録情報</h2>
        <form method="POST" action="/mypage/update" class="px-4 mb-6">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <li class="flex items-center flex-col md:flex-row mb-4">
                <label for="email" class="w-[200px] text-lg">メールアドレス</label>
                <input type="text" name="email" id="email" value="{{ $customer['email'] }}"
                    class="border border-gray-300 p-2">
            </li>
            <li class="flex items-center flex-col md:flex-row mb-4">
                <label for="tel" class="w-[200px] text-lg">電話番号</label>
                <input type="text" name="tel" id="tel" value="{{ $customer['tel'] }}"
                    class="border border-gray-300 p-2">
            </li>
            <li class="flex items-center flex-col md:flex-row mb-4">
                <label for="" class="w-[200px] text-lg">郵便番号</label>
                <input type="text" name="zip" id="" value="{{ $customer['zip'] }}"
                    class="border border-gray-300 p-2">
            </li>
            <li class="flex items-center flex-col md:flex-row mb-6">
                <label for="address" class="w-[200px] text-lg">住所</label>
                <input type="text" name="address" id="address" value="{{ $customer['address'] }}"
                    class="border border-gray-300 p-2">
            </li>

            <button
                class="rounded-full border border-gray-500 w-32 bg-white hover:bg-gray-700 hover:text-white mr-[20px]"><a
                    href="/mypage/detail" class="px-6 py-4 inline-block">戻る</a></button>
            <input type="submit" name="send"
                class="rounded-full border border-gray-500 w-32 bg-white hover:bg-red-700 hover:text-white px-6 py-4 hover:cursor-pointer"
                value="更新する">
        </form>
    </section>
@endsection
