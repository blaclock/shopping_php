@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold mb-5 md:mb-10">アカウントサービス</h2>
        {{-- {{ password_hash('testpass', PASSWORD_DEFAULT) }} --}}
        {{-- <div class="flex justify-between mb-8">
                <span class="font-bold">
                    ようこそ、{{ $_SESSION['customer']['family_name'] . $_SESSION['customer']['first_name'] }}さん
                </span>
                <a href="/logout" class="">ログアウト</a>
            </div> --}}
        <div class="flex flex-wrap mb-4">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <a href="{{ App\consts\CommonConst::APP_URL }}mypage/detail"
                class="md:w-[calc((100%_-_40px)/3)] w-full border border-gray-300 duration-200 bg-white hover:bg-gray-700 hover:text-white px-2 md:px-5 py-4 mr-5 [&:nth-child(3n)]:mr-0 [&:nth-child(n+2)]:mt-10 md:[&:nth-child(-n+3)]:mt-0 md:[&:nth-child(n+4)]:mt-10">
                <p class="md:text-2xl">登録情報</p>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}mypage/orders"
                class="md:w-[calc((100%_-_40px)/3)] w-full border border-gray-300 duration-200 bg-white hover:bg-gray-700 hover:text-white px-2 md:px-5 py-4 mr-5 [&:nth-child(3n)]:mr-0 mt-10 md:[&:nth-child(-n+3)]:mt-0 md:[&:nth-child(n+4)]:mt-10">
                <p class="md:text-2xl">注文履歴</p>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}mypage/contact"
                class="md:w-[calc((100%_-_40px)/3)] w-full border border-gray-300 duration-200 bg-white hover:bg-gray-700 hover:text-white px-2 md:px-5 py-4 [&:nth-child(3n)]:mr-0 mt-10 md:[&:nth-child(-n+3)]:mt-0 md:[&:nth-child(n+4)]:mt-10">
                <p class="md:text-2xl">お問い合わせ</p>
            </a>
        </div>
        <a href="/logout" class="hover:underline hover:opacity-80">ログアウト</a>
    </section>
@endsection
