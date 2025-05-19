@extends('layouts.app')

@push('css')
    <link rel="stylesheet"href="{{ App\consts\CommonConst::CSS_PATH }}tab-panel.css">
@endpush

@push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}tab-panel.js"></script>
@endpush


@section('content')
    {{-- <input type="hidden" name="entry_url" value="{{ constant('shopping\\Bootstrap::ENTRY_URL') }}" id="entry_url" /> --}}
    {{-- <div class="side">
            <p>MENU</p>
            {% include 'category_menu.html.twig' %}
        </div> --}}
    <div class="flex flex-col md:flex-row lg:w-[1000px] mx-auto mb-10 md:mb-20">
        <div class="mb-5 md:mb-0 md:mr-10">
            <div class="w-full md:w-[300px] lg:w-[500px] relative">
                <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $product['image'] }}"
                    alt="{{ $product['image'] }}" class="w-full">
                @if (in_array($product['id'], $favorites))
                    <a href="/mypage/favorites/remove?product_id={{ $product['id'] }}"
                        class="absolute top-4 right-4 inline-block w-6 h-6 bg-red-500"
                        style="clip-path:path('M12 4.248c-3.148-5.402-12-3.825-12 2.944 0 4.661 5.571 9.427 12 15.808 6.43-6.381 12-11.147 12-15.808 0-6.792-8.875-8.306-12-2.944z')">
                    </a>
                @else
                    <a href="/mypage/favorites/add?product_id={{ $product['id'] }}" class="">
                        <svg class="w-6 fill-a_text absolute top-4 right-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 19.771 17.501">
                            <path class=""
                                d="M-3107.872-749.553a5.6,5.6,0,0,1,4.284,1.985,5.6,5.6,0,0,1,4.272-1.974h0a5.639,5.639,0,0,1,.61.033,5.618,5.618,0,0,1,4.969,6.175c-.147,1.805-1.793,4.239-4.893,7.234a56.356,56.356,0,0,1-4.506,3.895.75.75,0,0,1-.908,0,56.379,56.379,0,0,1-4.506-3.894c-3.1-2.994-4.745-5.427-4.892-7.232a5.59,5.59,0,0,1,.608-3.216,5.585,5.585,0,0,1,2.311-2.335A5.619,5.619,0,0,1-3107.872-749.553Zm4.282,4.058h0a.75.75,0,0,1-.66-.395,4.106,4.106,0,0,0-3.622-2.163,4.113,4.113,0,0,0-1.941.491,4.088,4.088,0,0,0-2.137,4.076c0,.008,0,.017,0,.025.108,1.39,1.685,3.621,4.44,6.282,1.586,1.532,3.166,2.826,3.918,3.424.754-.6,2.34-1.9,3.928-3.434,2.749-2.657,4.322-4.885,4.43-6.273l0-.023a4.116,4.116,0,0,0-3.639-4.533,4.143,4.143,0,0,0-.448-.024,4.106,4.106,0,0,0-3.614,2.154A.75.75,0,0,1-3103.59-745.5Z"
                                transform="translate(3113.476 749.553)" fill="#ef4406" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>
        <div class="w-[100%-500px] text-gray-600">
            <h1 class="text-xl md:text-3xl mb-2">{{ $product['name'] }}</h1>
            <div class="flex items-center">
                @component('components.score', ['type' => 'average'])
                @endcomponent
                <span class="text-xl">({{ number_format((float) $score, 1, '.') }})</span>
            </div>
            @if (count($reviews) !== 0)
                <p class="text-sm mb-4">{{ count($reviews) }}件のレビューが登録されています</p>
            @endif
            {{-- <p class="mb-4">{!! $product['detail'] !!}</p> --}}
            <p class="text-2xl mb-4">&yen;{{ number_format($product['price']) }}<span class="text-sm">(税込)</span></p>
            <form action="/cart/add" method="POST" class="">
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                <div class="flex items-center mb-4">
                    <div class="flex items-center">
                        <label for="quantity" class="mr-4">数量</label>
                        <select name="quantity" id="quauntity" class="border border-gray-600 px-2 py-4 mr-4">
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" @if ($i === 1) selected @endif>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <button type="submit"
                        class="rounded-full border border-gray-500 w-[200px] px-4 py-4 bg-white hover:bg-gray-700 hover:text-white hover:cursor-pointer">
                        <svg class="absolute w-[21px] fill-a_text" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 21.333 21.5">
                            <g transform="translate(3041.953 749.554)">
                                <path
                                    d="M-3023.548-734.423h-11.044a.75.75,0,0,1-.728-.571l-2.174-8.826c0-.009,0-.018-.007-.027l-1.036-4.207h-2.666a.75.75,0,0,1-.75-.75.75.75,0,0,1,.75-.75h3.254a.75.75,0,0,1,.728.571l1.039,4.22h14.811a.75.75,0,0,1,.59.287.75.75,0,0,1,.138.642l-2.178,8.84A.75.75,0,0,1-3023.548-734.423Zm-10.456-1.5h9.869l1.808-7.34h-13.485Z"
                                    fill="#808080" />
                                <path
                                    d="M-3025.347-732.59a2.27,2.27,0,0,1,2.268,2.268,2.27,2.27,0,0,1-2.268,2.268,2.271,2.271,0,0,1-2.268-2.268A2.271,2.271,0,0,1-3025.347-732.59Zm0,3.036a.769.769,0,0,0,.768-.768.769.769,0,0,0-.768-.768.769.769,0,0,0-.768.768A.769.769,0,0,0-3025.347-729.554Z"
                                    fill="#808080" />
                                <path
                                    d="M-3032.988-732.59a2.271,2.271,0,0,1,2.268,2.268,2.271,2.271,0,0,1-2.268,2.268,2.271,2.271,0,0,1-2.268-2.268A2.271,2.271,0,0,1-3032.988-732.59Zm0,3.036a.769.769,0,0,0,.768-.768.769.769,0,0,0-.768-.768.769.769,0,0,0-.768.768A.769.769,0,0,0-3032.988-729.554Z"
                                    fill="#808080" />
                            </g>
                        </svg>
                        <span class="ml-2">カートに入れる</span>
                    </button>
                </div>
            </form>
            <article class="mt-10">
                <pre class="font-base whitespace-pre-wrap">{{ $product['detail'] }}</pre>
            </article>
        </div>
    </div>

    {{-- <section class="text-gray-600 body-font">
        <div class="container pb-20 mx-auto flex flex-wrap flex-col">
            <div class="tab-panel">
                <ul class="flex mx-auto flex-wrap lg:w-[1000px] tab-group">
                    <li
                        class="px-2 md:px-6 w-1/3 justify-center border-b-2 title-font font-medium bg-gray-200 inline-flex items-center leading-none text-gray-600 tracking-wider rounded-t tab tab-A is-active text-center">
                        <span>ストーリー</span>
                    </li>
                    <li
                        class="px-2 md:px-6 w-1/3 justify-center border-b-2 title-font font-medium bg-gray-200 inline-flex items-center leading-none border-gray-200 hover:text-gray-900 tracking-wider tab tab-B text-center">
                        <span>商品情報</span>
                    </li>
                    <li
                        class="px-2 md:px-6 w-1/3 justify-center border-b-2 title-font font-medium bg-gray-200 inline-flex items-center leading-none border-gray-200 hover:text-gray-900 tracking-wider tab tab-C text-center">
                        <span>飲み方</span>
                    </li>
                </ul>

                <div class="panel-group px-4 py-8 lg:w-[1000px] mx-auto">
                    <div class="panel tab-A is-show">contentA</div>
                    <div class="panel tab-B hidden">
                        <pre class="font-base whitespace-pre-wrap">{{ $product['detail'] }}</pre>
                    </div>
                    <div class="panel tab-C hidden">contentC</div>
                </div>

            </div>
    </section> --}}

    <section class="lg:w-[1000px] mx-auto">
        <h1 class="text-xl md:text-3xl mb-5">お客様の声</h1>
        @if (count($reviews) !== 0)
            <ul class="">
                @foreach ($reviews as $review)
                    <li class="mb-4 p-4 bg-gray-100">
                        <p class="mb-2">{{ $review['created_at'] }}</p>
                        <p>{{ $review['account_name'] }}さん</p>
                        <div>
                            @component('components.score', [
                                'type' => 'scores',
                                'review' => $review,
                            ])
                            @endcomponent
                        </div>
                        <p class="text-xl font-medium mb-2">{{ $review['title'] }}</p>
                        <pre class="font-base whitespace-pre-wrap">{{ $review['content'] }}</pre>
                        <p></p>
                        <p></p>
                    </li>
                @endforeach
            </ul>
        @else
            <p>まだこの商品へのレビューはありません。</p>
        @endif
    </section>
@endsection
