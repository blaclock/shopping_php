@extends('layouts.admin.app')

{{-- @push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}displayDropArea.js"></script>
@endpush --}}

@section('content')
    <section class="text-gray-600 body-font md:mb-[200px]">
        <h2 class="text-3xl font-bold mb-8">お問い合わせ</h2>
        @if (count($contacts) !== 0)
            <ul class="mb-10">
                @foreach ($contacts as $contact)
                    <li class="border border-gray-100 bg-white mb-5">
                        <a href="/admin/contact?customer_id={{ $contact['customer_id'] }}" class="hover:opacity-70">
                            <div class="flex bg-gray-100 px-5 py-5">
                                <span class="mr-5"> 受信日：{{ $contact['created_at'] }}</span>
                                <object data="" type=""><a
                                        href="/admin/customers?id={{ $contact['customer_id'] }}"><span
                                            class="">送信者：{{ $contact['account_name'] }}</span></a></object>
                            </div>
                            <div class="px-5 py-4 border-t-2 border-gray-200">
                                <pre>{{ $contact['message'] }}</pre>
                            </div>
                        </a>
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
@endsection
