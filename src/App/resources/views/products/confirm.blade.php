@extends('layouts.app')

@section('content')
    <div>
        <form method="post" action="/products/confirm" enctype="multipart/form-data">
            {{-- 二重登録防止のトークン --}}
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="flex mb-2">
                <p class="w-24">商品名</p>
                <p>{{ $productData['name'] }}</p>
            </div>
            <div class="flex mb-2">
                <p class="w-24">価格</p>
                <p>{{ $productData['price'] }}</p>
            </div>
            <div class="flex mb-2">
                <label for="image" class="w-24">画像</label>
                <input type="file" name="image" class="" id="image">
            </div>
            <div class="flex mb-2">
                <p class="w-24">カテゴリー</p>
                <p>{{ $productData['category'] }}</p>
            </div>
            <div class="flex mb-2">
                <p class="w-24">説明</p>
                <p>{{ $productData['detail'] }}</p>
            </div>
            <div class="flex mb-2">
                <input type="submit" name="send" value="{{ \App\consts\CommonConst::REGISTER_BACK }}"
                    class="border border-gray-600 mr-2">
                <input type="submit" name="send" value="{{ \App\consts\CommonConst::REGISTER_COMPLETE }}"
                    class="border border-gray-600">
            </div>
            @foreach ($productData as $column => $val)
                @if ($column === 'image')
                    <input type="hidden" name="{{ $column }}" value="{{ $val['name'] }}">
                @else
                    <input type="hidden" name="{{ $column }}" value="{{ $val }}">
                @endif
            @endforeach
        </form>
    </div>
    <script>
        history.replaceState(null, '');
    </script>
@endsection
