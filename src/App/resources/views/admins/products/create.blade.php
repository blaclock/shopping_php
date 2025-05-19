@extends('layouts.admin.app')


@push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}image_upload.js"></script>
@endpush

@section('content')
    <ul class="">
        <form method="post" action="/admin/product/confirm" enctype="multipart/form-data">
            <li class="md:flex mb-4">
                <label for="name" class="w-[200px] text-lg mb-2 md:mb-0 inline-block">商品名</label>
                <div>
                    <input type="text" name="name" class="border border-gray-300 p-2 w-80" id="name"
                        value="{{ $productData['name'] }}">
                    @if (isset($errMessage))
                        @foreach ($errMessage['name'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="md:flex mb-4">
                <label for="price" class="w-[200px] text-lg mb-2 md:mb-0 inline-block">価格(税込)</label>
                <div>
                    <input type="text" name="price" class="border border-gray-300 p-2" id="price"
                        value="{{ $productData['price'] }}">
                    @if (isset($errMessage))
                        @foreach ($errMessage['price'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="md:flex mb-4">
                <label for="image" class="w-[200px] text-lg mb-2 md:mb-0 inline-block">画像</label>
                <div class="flex">
                    <div class="w-80 py-10 border border-dashed border-gray-700 bg-gray-50" id="drop-zone">
                        <div class="text-center">
                            @if (isset($errMessage))
                                @foreach ($errMessage['image'] as $error)
                                    <p class="text-red-400">{{ $error }}</p>
                                @endforeach
                            @endif
                            <p class="mb-2">ファイルをドラッグ＆ドロップ<br>もしくは</p>
                            <input type="file" name="image" id="image" class="hidden">
                            <label for="image"
                                class="inline-block mx-auto py-2 px-2 border border-gray-300 bg-white hover:bg-gray-700 hover:text-white duration-200">ファイルを選択</label>
                        </div>
                    </div>
                    <div class="w-[200px] ml-5" id="preview">
                    </div>
                </div>
            </li>
            <li class="md:flex mb-4">
                <p class="w-[200px] text-lg mb-2 md:mb-0 inline-block">カテゴリー</p>
                <div class="">
                    @foreach ($categories as $category)
                        <input type="radio" name="category" value="{{ $category['id'] }}"
                            class="border border-gray-300 p-2" id="category_{{ $category['id'] }}"
                            @if ($category['id'] == $productData['category']) checked="checked" @endif>
                        <label for="category_{{ $category['id'] }}"
                            class="w-[200px] text-lg">{{ $category['name'] }}</label>
                    @endforeach

                    @if (isset($errMessage))
                        @foreach ($errMessage['category'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="md:flex mb-4">
                <label for="detail" class="w-[200px] text-lg mb-2 md:mb-0 inline-block">説明</label>
                <div>
                    <textarea type="text" name="detail" class="border border-gray-300 p-2" rows="4" cols="40" id="detail">{{ $productData['detail'] }}</textarea>
                    @if (isset($errMessage))
                        @foreach ($errMessage['detail'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex mb-2">
                {{-- <label for="detail" class="w-24">説明</label> --}}
                {{-- <button type="submit" class="border border-gray-600">登録する</button>
                <button type="submit" class="border border-gray-600">登録する</button> --}}
                <input type="submit" name="send" value="{{ \App\consts\CommonConst::REGISTER_CONFIRM }}"
                    class="rounded-full border border-gray-500 w-32 bg-white hover:bg-gray-700 hover:text-white px-6 py-4 hover:cursor-pointer">
            </li>
        </form>
        {{-- {{ phpinfo() }} --}}
    </ul>
@endsection
