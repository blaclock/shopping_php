@extends('layouts.admin.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold mb-10">登録情報</h2>
        <ul class="px-4">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <li class="flex flex-col md:flex-row mb-5">
                <span class="w-[200px] text-lg font-bold">名前</span>
                <span>{{ $admin['family_name'] . ' ' . $admin['first_name'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-5">
                <span class="w-[200px] text-lg font-bold">名前(カナ)</span>
                <span>{{ $admin['family_name_kana'] . ' ' . $admin['first_name_kana'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row mb-5">
                <span class="w-[200px] text-lg font-bold">メールアドレス</span>
                <span>{{ $admin['email'] }}</span>
            </li>
            <li class="flex flex-col md:flex-row">
                <span class="w-[200px] text-lg font-bold">登録日</span>
                <span>{{ $admin['created_at'] }}</span>
            </li>
        </ul>
    </section>
@endsection
