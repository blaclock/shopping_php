@extends('layouts.admin.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-3xl font-bold">管理者メニュー</h2>
        {{-- <div class="flex justify-between mb-8">
                <span class="font-bold">
                    ようこそ、{{ $_SESSION['customer']['family_name'] . $_SESSION['customer']['first_name'] }}さん
                </span>
                <a href="/logout" class="">ログアウト</a>
            </div> --}}
        <div class="flex flex-wrap m-4">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/admins"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 duration-200 bg-white hover:bg-gray-700 hover:text-white mr-5 [&:nth-child(3n)]:mr-0 [&:nth-child(n-3)]:mt-10">
                <span>管理者情報</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/customers"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 duration-200 bg-white hover:bg-gray-700 hover:text-white mr-5 [&:nth-child(3n)]:mr-0 [&:nth-child(n-3)]:mt-10">
                <span>顧客情報管理</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/products/top"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 duration-200 bg-white hover:bg-gray-700 hover:text-white mr-5 [&:nth-child(3n)]:mr-0 [&:nth-child(n-3)]:mt-10 [&:nth-child(3n+1)]:mr-0">
                <span>商品管理</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/orders"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 duration-200 bg-white hover:bg-gray-700 hover:text-white mr-5 [&:nth-child(3n)]:mr-0 [&:nth-child(n-3)]:mt-10">
                <span>注文履歴</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/contacts"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 duration-200 bg-white hover:bg-gray-700 hover:text-white mr-5 [&:nth-child(3n)]:mr-0 [&:nth-child(n-3)]:mt-10">
                <span>お問い合わせ</span>
            </a>
        </div>
        <a href="/admin/logout" class="hover:underline hover:opacity-80">ログアウト</a>
    </section>
@endsection
