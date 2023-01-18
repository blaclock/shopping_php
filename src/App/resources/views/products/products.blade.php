<section class="text-gray-600 body-font">
    <div>
        <div class="flex flex-wrap -m-4">
            @foreach ($products as $product)
                <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                    <p class="product-name">{{ $product['item_name'] }}</p>
                    <img src="{{ App\consts\CommonConst::IMG_PATH }}products/{{ $product['image'] }}"
                        alt="{{ $product['image'] }}">
                    <div>
                        <span>&yen;{{ number_format($product['price']) }}</span>
                        <a href="{{ App\consts\CommonConst::APP_URL }}products/?id={{ $product['item_id'] }}">詳細</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
