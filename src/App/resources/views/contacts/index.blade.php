@extends('layouts.app')

{{-- @push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}displayDropArea.js"></script>
@endpush --}}

@section('content')
    <section class="text-gray-600 body-font md:mb-[200px]">
        <h2 class="text-3xl font-bold mb-8">お問い合わせ</h2>
        @if (count($contacts) !== 0)
            <ul class="mb-10">
                @foreach ($contacts as $contact)
                    <li
                        class="w-11/12 border border-gray-100 bg-white mb-5 @if ($contact['sender'] === 'customer') ml-auto @endif">
                        <div class="flex flex-col md:flex-row bg-gray-100 px-5 py-5">
                            <span class="mr-10">送信日：<br class="hidden md:inline">{{ $contact['created_at'] }}</span>
                            {{-- <a href="/admin/customers?id={{ $contact['customer_id'] }}"><span class="">送信者：<br
                                        class="hidden md:inline">{{ $contact['account_name'] }}</span></a> --}}
                        </div>
                        <div class="flex px-5 py-4 border-t-2 border-gray-200">
                            {{-- <span>{{ nl2br($contact['message']) }}</span> --}}
                            <pre>{{ $contact['message'] }}</pre>
                            {{-- <p>{{ $contact['message'] }}</p> --}}
                        </div>
                    </li>
                @endforeach
            </ul>
            {{-- @if ($pagination['pageNum'] > 1)
                @component('components.pagination', ['pageUrl' => '/admin/contacts?'])
                @endcomponent
            @endif --}}
        @else
            <p class="">お問い合わせが登録されていません。</p>
        @endif
    </section>
    <form action="/mypage/contact/send" method="post"
        class="w-full md:w-3/4 mx-auto md:fixed bottom-[120px] md:bottom-[80px]">
        @if (isset($errMessage['message']['empty']))
            <p class="text-red-400">{{ $errMessage['message']['empty'] }}</p>
        @endif
        <textarea name="message" id="" class="w-full h-[100px] md:h-[200px] border border-gray-700"></textarea>
        <input type="submit" value="送信" class="rounded-lg px-10 py-4 bg-gray-700 text-white hover:opacity-70">
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="customer_id" value="{{ $contact['customer_id'] }}">
    </form>
@endsection
