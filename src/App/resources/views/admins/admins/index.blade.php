@extends('layouts.admin.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold mb-5 md:mb-10">管理者一覧</h2>

        @if ($admins !== false)
            <p class="mb-2 md:mb-5">{{ count($admins) }}人の管理者が登録されています。</p>
            <ul class="">
                @foreach ($admins as $admin)
                    <li class="border border-gray-100 bg-white mb-5">

                        <div class="flex bg-gray-100 px-5 py-5">
                            <span class="">登録日：{{ $admin['created_at'] }}</span>
                        </div>
                        <div class="flex flex-col px-5 py-4 border-t-2 border-gray-200">

                            <span class="text-2xl">{{ $admin['family_name'] . ' ' . $admin['first_name'] }}</span>
                            <p class="mt-2">
                                <a href="/admin/admins?id={{ $admin['id'] }}" class="mr-4 hover:opacity-70">詳細</a>

                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>顧客が登録されていません。</p>
        @endif
    </section>
@endsection
