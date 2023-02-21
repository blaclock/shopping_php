@extends('layouts.app')

@push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}review.js"></script>
@endpush

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold mb-4">この商品をレビュー</h2>
        <div class="flex items-center mb-8">
            <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $product['image'] }}" alt="{{ $product['image'] }}"
                class="w-20">
            <span class="ml-4">{{ $product['name'] }}</span>
        </div>
        <form method="POST" action="/product/review/store" class="px-4 mb-6">
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <li class="flex flex-col items-center md:flex-row mb-4">
                <label for="title" class="w-[200px] text-lg">レビュータイトル</label>
                <div class="">
                    <input type="text" name="title" id="title" value="{{ $review['title'] }}"
                        class="lg:w-[700px] border border-gray-300 p-2">
                    @if (isset($errMessage['title']))
                        @foreach ($errMessage['title'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col items-center md:flex-row mb-4">
                <label for="content" class="w-[200px] text-lg">レビューを追加</label>
                <div class="">
                    <textarea name="content" id="content" class="border border-gray-300 p-2 w-[700px] h-[130px]">{{ $review['content'] }}</textarea>
                    @if (isset($errMessage['content']))
                        @foreach ($errMessage['content'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col items-center md:flex-row mb-10">
                <span class="w-[200px] text-lg">評価</span>
                <div class="">
                    <div class="flex">
                        <input type="radio" name="score" id="score0" value="0" class="hidden" checked="checked">
                        <div class="">
                            <label for="score1" class="score text-lg w-6 h-6 inline-block"
                                style="background-color: rgb(75,85,99);clip-path: polygon(50% 5%, 61% 40%, 98% 40%, 68% 62%, 79% 96%, 50% 75%, 21% 96%, 32% 62%, 2% 40%, 39% 40%);"></label>
                            <input type="radio" name="score" id="score1" value="1" class="hidden">
                        </div>
                        <div class="">
                            <label for="score2" class="score text-lg w-6 h-6 inline-block"
                                style="background-color: rgb(75,85,99);clip-path: polygon(50% 5%, 61% 40%, 98% 40%, 68% 62%, 79% 96%, 50% 75%, 21% 96%, 32% 62%, 2% 40%, 39% 40%);"></label>
                            <input type="radio" name="score" id="score2" value="2" class="hidden">
                        </div>
                        <div class="">
                            <label for="score3" class="score text-lg w-6 h-6 inline-block"
                                style="background-color: rgb(75,85,99);clip-path: polygon(50% 5%, 61% 40%, 98% 40%, 68% 62%, 79% 96%, 50% 75%, 21% 96%, 32% 62%, 2% 40%, 39% 40%);"></label>
                            <input type="radio" name="score" id="score3" value="3" class="hidden">
                        </div>
                        <div class="">
                            <label for="score4" class="score text-lg w-6 h-6 inline-block"
                                style="background-color: rgb(75,85,99);clip-path: polygon(50% 5%, 61% 40%, 98% 40%, 68% 62%, 79% 96%, 50% 75%, 21% 96%, 32% 62%, 2% 40%, 39% 40%);"></label>
                            <input type="radio" name="score" id="score4" value="4" class="hidden">
                        </div>
                        <div class="">
                            <label for="score5" class="score text-lg w-6 h-6 inline-block"
                                style="background-color: rgb(75,85,99);clip-path: polygon(50% 5%, 61% 40%, 98% 40%, 68% 62%, 79% 96%, 50% 75%, 21% 96%, 32% 62%, 2% 40%, 39% 40%);"></label>
                            <input type="radio" name="score" id="score5" value="5" class="hidden">
                        </div>
                    </div>

                    @if (isset($errMessage['score']))
                        @foreach ($errMessage['score'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>

            <input type="submit" name="send"
                class="rounded-full border border-gray-500 w-32 bg-white hover:bg-gray-700 hover:text-white px-6 py-4 hover:cursor-pointer"
                value="投稿">
        </form>
    </section>
@endsection
