@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold">アカウントサービス</h2>
        {{-- <div class="flex justify-between mb-8">
                <span class="font-bold">
                    ようこそ、{{ $_SESSION['customer']['family_name'] . $_SESSION['customer']['first_name'] }}さん
                </span>
                <a href="/logout" class="">ログアウト</a>
            </div> --}}
        <div class="flex flex-wrap m-4">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <a href="{{ App\consts\CommonConst::APP_URL }}mypage/detail"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 hover:bg-gray-100 mr-[20px]">
                <p>登録情報</p>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}mypage/orders"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 hover:bg-gray-100 mr-[20px]">
                <p>注文履歴</p>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}contact"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 hover:bg-gray-100 mr-[20px] [&:nth-child(3n+1)]:mr-0">
                <p>お問い合わせ</p>
            </a>
        </div>
        <a href="/logout" class="hover:underline hover:opacity-80">ログアウト</a>
    </section>
@endsection
