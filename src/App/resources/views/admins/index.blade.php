@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold">管理者</h2>
        {{-- <div class="flex justify-between mb-8">
                <span class="font-bold">
                    ようこそ、{{ $_SESSION['customer']['family_name'] . $_SESSION['customer']['first_name'] }}さん
                </span>
                <a href="/logout" class="">ログアウト</a>
            </div> --}}
        <div class="flex flex-wrap m-4">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/detail"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 hover:bg-gray-100 mr-[20px]">
                <span>登録情報</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/customers"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 hover:bg-gray-100 mr-[20px]">
                <span>顧客情報管理</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/products"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 hover:bg-gray-100 mr-[20px] [&:nth-child(3n+1)]:mr-0">
                <span>商品管理</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/orders"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 hover:bg-gray-100 mr-[20px]">
                <span>注文履歴</span>
            </a>
        </div>
        <a href="/admin/logout" class="hover:underline hover:opacity-80">ログアウト</a>
    </section>
@endsection
