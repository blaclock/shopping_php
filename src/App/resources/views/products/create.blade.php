@extends('layouts.app')

@section('content')
    <div>
        <form method="post" action="/products/confirm" enctype="multipart/form-data">
            <div class="flex mb-2">
                <label for="name" class="w-24">商品名</label>
                <input type="text" name="name" class="border border-gray-600" id="name"
                    value="{{ $productData['name'] }}">
                @if (isset($errMessage))
                    @foreach ($errMessage['name'] as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                @endif

            </div>
            <div class="flex mb-2">
                <label for="price" class="w-24">価格</label>
                <input type="text" name="price" class="border border-gray-600" id="price"
                    value="{{ $productData['price'] }}">
                @if (isset($errMessage))
                    @foreach ($errMessage['price'] as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                @endif
            </div>
            <div class="flex mb-2">
                <label for="image" class="w-24">画像</label>
                <input type="file" name="image" class="" id="image">
                @if (isset($errMessage))
                    @foreach ($errMessage['image'] as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                @endif
            </div>
            <div class="flex mb-2">
                <p class="w-24">カテゴリー</p>
                <div class="">
                    @foreach ($categories as $category)
                        <input type="radio" name="category" value="{{ $category['id'] }}" class="border border-gray-600"
                            id="category_{{ $category['id'] }}" @if ($category['id'] == $productData['category']) checked="checked" @endif>
                        <label for="category_{{ $category['id'] }}" class="w-24">{{ $category['name'] }}</label>
                    @endforeach
                </div>
                @if (isset($errMessage))
                    @foreach ($errMessage['category'] as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                @endif
            </div>
            <div class="flex mb-2">
                <label for="detail" class="w-24">説明</label>
                <textarea type="text" name="detail" class="border border-gray-600" rows="4" cols="40" id="detail">{{ $productData['detail'] }}</textarea>
                @if (isset($errMessage))
                    @foreach ($errMessage['detail'] as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                @endif
            </div>
            <div class="flex mb-2">
                {{-- <label for="detail" class="w-24">説明</label> --}}
                {{-- <button type="submit" class="border border-gray-600">登録する</button>
                <button type="submit" class="border border-gray-600">登録する</button> --}}
                <input type="submit" name="send" value="{{ \App\consts\CommonConst::REGISTER_CONFIRM }}"
                    class="border border-gray-600">
            </div>
        </form>
        {{-- {{ phpinfo() }} --}}
    </div>
@endsection
