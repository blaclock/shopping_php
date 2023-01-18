@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold mb-4">新規登録</h2>
        <form method="POST" action="/register/confirm" class="px-4 mb-6">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <li class="flex flex-col items-center md:flex-row mb-4">
                <label for="family_name" class="w-[200px] text-lg">氏</label>
                <span>{{ $customer['family_name'] }}</span>
            </li>
            <li class="flex flex-col items-center md:flex-row mb-4">
                <label for="first_name" class="w-[200px] text-lg">名</label>
                <span>{{ $customer['first_name'] }}</span>
            </li>
            <li class="flex flex-col items-center md:flex-row mb-4">
                <label for="family_name_kana" class="w-[200px] text-lg">氏(カナ)</label>
                <span>{{ $customer['family_name_kana'] }}</span>
            </li>
            <li class="flex flex-col items-center md:flex-row mb-4">
                <label for="first_name_kana" class="w-[200px] text-lg">名(カナ)</label>
                <span>{{ $customer['first_name_kana'] }}</span>
            </li>
            <li class="flex flex-col items-center md:flex-row mb-4">
                <label for="account_name" class="w-[200px] text-lg">名(カナ)</label>
                <span>{{ $customer['account_name'] }}</span>
            </li>
            <li class="flex flex-col items-center md:flex-row mb-4">
                <p class="w-[200px] text-lg">性別</p>
                <span>{{ $customer['sex'] }}</span>
            </li>
            <li class="flex flex-col items-center md:flex-row mb-4">
                <label for="birth" class="w-[200px] text-lg">生年月日</label>
                <span>{{ $customer['birth'] }}</span>
            </li>
            <li class="flex flex-col items-center md:flex-row mb-4">
                <label for="email" class="w-[200px] text-lg">メールアドレス</label>
                <span>{{ $customer['email'] }}</span>
            </li>
            <li class="flex flex-col items-center md:flex-row mb-4">
                <label for="tel" class="w-[200px] text-lg">電話番号</label>
                <span>{{ $customer['tel'] }}</span>
            </li>
            <li class="flex flex-col items-center md:flex-row mb-4">
                <label for="" class="w-[200px] text-lg">郵便番号</label>
                <span>{{ $customer['zip'] }}</span>
            </li>
            <li class="flex flex-col items-center md:flex-row mb-6">
                <label for="address" class="w-[200px] text-lg">住所</label>
                <span>{{ $customer['address'] }}</span>
            </li>
            <li class="flex flex-col items-center md:flex-row mb-6">
                <label for="password" class="w-[200px] text-lg">パスワード</label>
                <span>{{ $customer['password'] }}</span>
            </li>

            @foreach ($customer as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach

            <input type="hidden" name="token" value="{{ $token }}">

            <input type="submit" name="send"
                class="rounded-full border border-gray-500 w-32 mr-[20px] bg-white hover:bg-gray-700 hover:text-white px-6 py-4 hover:cursor-pointer"
                value="戻る">
            <input type="submit" name="send"
                class="rounded-full border border-gray-500 w-32 bg-white hover:bg-red-700 hover:text-white px-6 py-4 hover:cursor-pointer"
                value="登録完了">
        </form>
    </section>
    <script>
        history.replaceState(null, '');
    </script>
@endsection
