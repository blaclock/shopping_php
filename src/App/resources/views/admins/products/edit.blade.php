@extends('layouts.admin.app')

@push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}image_upload.js"></script>
@endpush

@section('content')
    <ul class="">
        <form method="post" action="/admin/product/update?id={{ $productData['id'] }}" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{ $productData['id'] }}">
            <li class="md:flex mb-4">
                <label for="name" class="w-[200px] text-lg">商品名</label>
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
                <label for="price" class="w-[200px] text-lg">価格(税込)</label>
                <div>
                    <input type="text" name="price" class="border border-gray-300 p-2" id="price"
                        value="{{ number_format($productData['price'], 0, '.', '') }}">
                    @if (isset($errMessage))
                        @foreach ($errMessage['price'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="md:flex mb-4">
                <label for="image" class="w-[200px] text-lg">画像</label>
                <div class="flex">
                    <div class="w-80 py-10 border border-dashed border-gray-700" id="drop-zone">
                        <div class="h-full flex flex-col justify-center">
                            @if (isset($errMessage))
                                @foreach ($errMessage['image'] as $error)
                                    <p class="text-red-400">{{ $error }}</p>
                                @endforeach
                            @endif
                            <p class="mb-2 text-center">ファイルをドラッグ＆ドロップ<br>もしくは</p>
                            <input type="file" name="image" id="image" class="hidden">
                            <label for="image"
                                class="inline-block mx-auto py-2 px-2 border border-gray-300 bg-white hover:bg-gray-700 hover:text-white duration-200">ファイルを選択</label>
                        </div>
                    </div>
                    <div class="w-[200px] ml-5" id="preview">
                        @if (isset($productData['image']['name']))
                            <img src="{{ \App\consts\CommonConst::IMG_PATH }}products/{{ $productData['image']['name'] }}"
                                alt="{{ $productData['image']['name'] }}" class="">
                            <input type="hidden" name="image" value="{{ $productData['image'] }}">
                        @else
                            {{-- <img src="{{ \App\consts\CommonConst::IMG_PATH }}products/{{ $productData['image'] }}"
                                alt="{{ $productData['image'] }}" class="">
                            <input type="hidden" name="image" value="{{ $productData['image'] }}"> --}}
                            @if (isset($productData['image']))
                                <img src="{{ \App\consts\CommonConst::IMG_PATH }}products/{{ $productData['image'] }}"
                                    alt="{{ $productData['image'] }}" class="">
                                <input type="hidden" name="presentImage" value="{{ $productData['image'] }}">
                            @else
                                <img src="{{ \App\consts\CommonConst::IMG_PATH }}products/{{ $productData['presentImage'] }}"
                                    alt="{{ $productData['presentImage'] }}" class="">
                                <input type="hidden" name="presentImage" value="{{ $productData['presentImage'] }}">
                            @endif
                        @endif
                    </div>
                </div>
            </li>
            <li class="md:flex mb-4">
                <p class="w-[200px] text-lg">カテゴリー</p>
                <div class="">
                    @foreach ($categories as $category)
                        <input type="radio" name="category_id" value="{{ $category['id'] }}"
                            class="border border-gray-300 p-2" id="category_{{ $category['id'] }}"
                            @if ($category['id'] == $productData['category_id']) checked="checked" @endif>
                        <label for="category_{{ $category['id'] }}"
                            class="w-[200px] text-lg">{{ $category['name'] }}</label>
                    @endforeach

                    @if (isset($errMessage))
                        @foreach ($errMessage['category_id'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="md:flex mb-4">
                <label for="detail" class="w-[200px] text-lg">説明</label>
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
                <input type="submit" name="send" value="{{ \App\consts\CommonConst::UPDATE_CONFIRM }}"
                    class="rounded-full border border-gray-500 w-32 bg-white hover:bg-gray-700 hover:text-white px-6 py-4 hover:cursor-pointer">
            </li>
        </form>
        {{-- {{ phpinfo() }} --}}
    </ul>
@endsection
