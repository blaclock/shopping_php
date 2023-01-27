@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold">顧客一覧</h2>

        @if ($customers !== false)
            <p>{{ count($customers) }}人の顧客が登録されています。</p>
            <ul class="p-8 bg-white">
                @foreach ($customers as $customer)
                    <li class="flex py-4 border-t-2 border-gray-200">
                        {{-- <a href="/product?id={{ $customer['product_id'] }}" class="hover:opacity-80">
                            <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $customer['image'] }}"
                                alt="{{ $customer['name'] }}" class="w-[200px] mr-4">
                        </a> --}}
                        <div class="flex flex-col">
                            <span class="mb-2">登録日：{{ $customer['created_at'] }}</span>
                            <span class="text-2xl">{{ $customer['family_name'] . ' ' . $customer['first_name'] }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>顧客が登録されていません。</p>
        @endif

        <a href="/admin" class="hover:underline hover:opacity-80">管理画面トップ</a>
    </section>
@endsection
