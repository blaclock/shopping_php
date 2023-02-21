@extends('layouts.admin.app')

@section('content')
    <section class="text-gray-600 body-font min-h-screen">
        <h2 class="text-2xl font-bold">商品管理</h2>

        <div class="flex flex-wrap m-4">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/products"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 duration-200 bg-white hover:bg-gray-700 hover:text-white mr-5 [&:nth-child(3n)]:mr-0 [&:nth-child(n-3)]:mt-10">
                <span>商品一覧</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/product/register"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 duration-200 bg-white hover:bg-gray-700 hover:text-white mr-5 [&:nth-child(3n)]:mr-0 [&:nth-child(n-3)]:mt-10">
                <span>商品登録</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/csv_import?data=products"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 duration-200 bg-white hover:bg-gray-700 hover:text-white mr-5 [&:nth-child(3n)]:mr-0 [&:nth-child(n-3)]:mt-10">
                <span>CSVインポート</span>
            </a>
            <a href="{{ App\consts\CommonConst::APP_URL }}admin/csv_export?data=products"
                class="lg:w-1/4 md:w-1/2 p-6 w-full border border-gray-300 duration-200 bg-white hover:bg-gray-700 hover:text-white mr-5 [&:nth-child(3n)]:mr-0 [&:nth-child(n-3)]:mt-10">
                <span>CSVエクスポート</span>
            </a>
        </div>
    </section>
@endsection
