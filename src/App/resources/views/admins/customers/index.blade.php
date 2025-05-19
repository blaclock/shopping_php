@extends('layouts.admin.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold">顧客一覧</h2>

        @if ($customers !== false)
            <p>{{ $customerNum }}人の顧客が登録されています。</p>
            <ul class="mt-5 md:mt-10">
                @foreach ($customers as $customer)
                    <li class="border border-gray-100 bg-white mb-5">

                        <div class="flex bg-gray-100 px-5 py-5">
                            <span class="">登録日：{{ $customer['created_at'] }}</span>
                            <a href="/admin/customers/delete?customer_id={{ $customer['id'] }}"
                                class="ml-auto rounded-lg px-2 md:px-4 py-1 md:py-2 bg-red-700 text-white hover:opacity-70">強制退会</a>
                        </div>
                        <div class="flex flex-col px-5 py-4 border-t-2 border-gray-200">

                            <span class="text-2xl">{{ $customer['family_name'] . ' ' . $customer['first_name'] }}</span>
                            <p class="mt-2">
                                <a href="/admin/customers?id={{ $customer['id'] }}" class="mr-4 hover:opacity-70">詳細</a>

                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>顧客が登録されていません。</p>
        @endif

        {{-- <div class="mt-5">
            <form action=""></form>
            <input type="file" name="csv">
            <input type="submit" name="send"
                class="rounded-full border border-gray-500 inline-block mr-[20px] bg-white hover:bg-gray-700 hover:text-white px-6 py-4 hover:cursor-pointer"
                value="CSVインポート">
            <input type="submit" name="send"
                class="rounded-full border border-gray-500 inline-block bg-white hover:bg-red-700 hover:text-white px-6 py-4 hover:cursor-pointer"
                value="CSVエクスポート">
        </div> --}}

    </section>
    @if ($pagination['pageNum'] > 1)
        @component('components.pagination', ['pageUrl' => '/admin/customers?'])
        @endcomponent
    @endif
@endsection
