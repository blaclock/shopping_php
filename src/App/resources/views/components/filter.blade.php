<div class="inline-block ml-5 filter">
    <span class="inline-block ml-auto text-lg text-right px-2 py-2 hover:cursor-pointer">フィルター</span>
    <div class="absolute left-0 hidden dropArea w-full z-40">
        <form action="/products" method="get" class="p-8 w-full bg-gray-300">
            @foreach ($filterQuery as $key => $query)
                @if ($key === 'q' || $key === 'category_id')
                    <input type="hidden" name="{{ $key }}" value="{{ $query }}">
                @endif
            @endforeach
            <div class="flex flex-col md:flex-row mb-4">
                <span class="text-xl mr-4">価格：</span>
                <div class="">
                    <select name="price_low" class="border border-gray-600 ">
                        <option value=""></option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i * 1000 }}"
                                @if (isset($filterQuery['price_low'])) @if ($filterQuery['price_low'] == $i * 1000) selected @endif
                                @endif>
                                {{ number_format($i * 1000) }}円</option>
                        @endfor
                    </select>
                    <span>〜</span>
                    <select name="price_high" class="border border-gray-600 ">
                        <option value=""></option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i * 1000 }}"
                                @if (isset($filterQuery['price_high'])) @if ($filterQuery['price_high'] == $i * 1000) selected @endif
                                @endif>
                                {{ number_format($i * 1000) }}円</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="flex flex-col md:flex-row mb-4">
                <span class="text-xl mr-4">評価：</span>
                <select name="score_filter" class="border border-gray-600 ">
                    <option value=""></option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}"
                            @if (isset($filterQuery['score_filter'])) @if ($filterQuery['score_filter'] == $i) selected @endif
                            @endif>
                            {{ $i }}以上</option>
                    @endfor
                </select>
            </div>
            <div class="flex flex-col md:flex-row mb-10">
                <span class="text-xl mr-4">カテゴリー：</span>
                <select name="category_id" class="border border-gray-600 ">
                    <option value=""></option>
                    <option value="1"
                        @if (isset($filterQuery['category_id'])) @if ($filterQuery['category_id'] == '1') selected @endif
                        @endif>日本酒</option>
                    <option value="2"
                        @if (isset($filterQuery['category_id'])) @if ($filterQuery['category_id'] == '2') selected @endif
                        @endif>ビール</option>
                    <option value="3"
                        @if (isset($filterQuery['category_id'])) @if ($filterQuery['category_id'] == '3') selected @endif
                        @endif>ワイン</option>
                </select>
                {{-- <select name="category_filter" class="border border-gray-600 ">
                    <option value=""></option>
                    <option value="日本酒"
                        @if (isset($filterQuery['category_filter'])) @if ($filterQuery['category_filter'] == '日本酒') selected @endif
                        @endif>日本酒</option>
                    <option value="ビール"
                        @if (isset($filterQuery['category_filter'])) @if ($filterQuery['category_filter'] == 'ビール') selected @endif
                        @endif>ビール</option>
                    <option value="ワイン"
                        @if (isset($filterQuery['category_filter'])) @if ($filterQuery['category_filter'] == 'ワイン') selected @endif
                        @endif>ワイン</option>
                </select> --}}
            </div>
            <div class="text-right">
                <input type="submit" value="絞り込み"
                    class="rounded-full border border-gray-500 w-[200px] px-4 py-4 bg-white hover:bg-gray-700 hover:text-white hover:cursor-pointer duration-200">
            </div>
        </form>
    </div>
</div>
