@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold mb-4">登録情報</h2>
        <ul class="px-4 mb-8">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <li class="flex flex-col md:flex-row mb-2">
                <span class="w-[200px] text-lg">メールアドレス</span>
                <span>{{ $customer['email'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-2">
                <span class="w-[200px] text-lg">電話番号</span>
                <span>{{ $customer['tel'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-2">
                <span class="w-[200px] text-lg">郵便番号</span>
                <span>{{ $customer['zip'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row">
                <span class="w-[200px] text-lg">住所</span>
                <span>{{ $customer['address'] }}</span>
            </li>
        </ul>
        <form action="/mypage/update" method="POST">
            @foreach ($customer as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="submit" name="send"
                class="rounded-full border border-gray-500 w-32 px-6 py-4 mr-4 bg-white hover:bg-gray-700 hover:text-white hover:cursor-pointer"
                value="戻る">
            <input type="submit" name="send"
                class="rounded-full border border-gray-500 w-32 px-6 py-4 bg-white hover:bg-red-700 hover:text-white"
                value="{{ APP\consts\CommonConst::UPDATE_COMPLETE }}">
        </form>
    </section>
    <script>
        history.replaceState(null, '');
    </script>
@endsection
