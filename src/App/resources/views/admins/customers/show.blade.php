@extends('layouts.admin.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold mb-10">登録情報</h2>
        <ul class="px-4">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <li class="flex flex-col md:flex-row mb-5">
                <span class="w-[200px] text-lg font-bold">名前</span>
                <span>{{ $customer['family_name'] . ' ' . $customer['first_name'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-5">
                <span class="w-[200px] text-lg font-bold">名前(カナ)</span>
                <span>{{ $customer['family_name_kana'] . ' ' . $customer['first_name_kana'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-5">
                <span class="w-[200px] text-lg font-bold">アカウント名</span>
                <span>{{ $customer['account_name'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-5">
                <span class="w-[200px] text-lg font-bold">性別</span>
                <span>{{ $customer['sex'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-5">
                <span class="w-[200px] text-lg font-bold">生年月日</span>
                <span>{{ $customer['birth'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-5">
                <span class="w-[200px] text-lg font-bold">メールアドレス</span>
                <span>{{ $customer['email'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-5">
                <span class="w-[200px] text-lg font-bold">電話番号</span>
                <span>{{ $customer['tel'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-5">
                <span class="w-[200px] text-lg font-bold">郵便番号</span>
                <span>{{ $customer['zip'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-5">
                <span class="w-[200px] text-lg font-bold">住所</span>
                <span>{{ $customer['address'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row">
                <span class="w-[200px] text-lg font-bold">登録日</span>
                <span>{{ $customer['created_at'] }}</span>
            </li>
        </ul>
    </section>
@endsection
