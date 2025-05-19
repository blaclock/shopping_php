@extends('layouts.app')

@push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}postcode.js"></script>
@endpush

@section('content')
    <section class="text-gray-600 body-font">
        <h2 class="text-2xl font-bold mb-4">新規登録</h2>
        <form method="POST" action="/register/confirm" class="px-4 mb-6">
            {{-- <div class="xl:w-1/4 lg:w-1/3 md:w-1/2 p-6 w-full"> --}}
            <li class="flex flex-col md:items-center md:flex-row mb-4">
                <label for="family_name" class="w-[250px] text-lg">氏</label>
                <div>
                    <input type="text" name="family_name" id="family_name" value="{{ $customer['family_name'] }}"
                        class="border border-gray-300 p-2">
                    @if (isset($errMessage['family_name']))
                        @foreach ($errMessage['family_name'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col md:items-center md:flex-row mb-4">
                <label for="first_name" class="w-[250px] text-lg">名</label>
                <div>
                    <input type="text" name="first_name" id="first_name" value="{{ $customer['first_name'] }}"
                        class="border border-gray-300 p-2">
                    @if (isset($errMessage['first_name']))
                        @foreach ($errMessage['first_name'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col md:items-center md:flex-row mb-4">
                <label for="family_name_kana" class="w-[250px] text-lg">氏(カナ)</label>
                <div>
                    <input type="text" name="family_name_kana" id="family_name_kana"
                        value="{{ $customer['family_name_kana'] }}" class="border border-gray-300 p-2">
                    @if (isset($errMessage['family_name_kana']))
                        @foreach ($errMessage['family_name_kana'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col md:items-center md:flex-row mb-4">
                <label for="first_name_kana" class="w-[250px] text-lg">名(カナ)</label>
                <div>
                    <input type="text" name="first_name_kana" id="first_name_kana"
                        value="{{ $customer['first_name_kana'] }}" class="border border-gray-300 p-2">
                    @if (isset($errMessage['first_name_kana']))
                        @foreach ($errMessage['first_name_kana'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col md:items-center md:flex-row mb-4">
                <label for="account_name" class="w-[250px] text-lg">アカウント名</label>
                <div>
                    <input type="text" name="account_name" id="account_name" value="{{ $customer['account_name'] }}"
                        class="border border-gray-300 p-2">
                    @if (isset($errMessage['account_name']))
                        @foreach ($errMessage['account_name'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col md:items-center md:flex-row mb-4">
                <p class="w-[250px] text-lg">性別</p>
                <div>
                    <input type="radio" name="sex" value="男" class="border border-gray-600" id="男"
                        @if (isset($customer['sex'])) @if ($customer['sex'] == '男') checked="checked" @endif
                        @endif
                    >
                    <label for="男" class="mr-[20px]">男</label>
                    <input type="radio" name="sex" value="女" class="border border-gray-600" id="女"
                        @if (isset($customer['sex'])) @if ($customer['sex'] == '女') checked="checked" @endif
                        @endif
                    >
                    <label for="女" class="w-24">女</label>
                    @if (isset($errMessage['sex']))
                        @foreach ($errMessage['sex'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col md:items-center md:flex-row mb-4">
                <label for="birth" class="w-[250px] text-lg">生年月日</label>
                <div>
                    <input type="date" name="birth" id="birth" value="{{ $customer['birth'] }}"
                        class="border border-gray-300 p-2">
                    @if (isset($errMessage['birth']))
                        @foreach ($errMessage['birth'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col md:items-center md:flex-row mb-4">
                <label for="email" class="w-[250px] text-lg">メールアドレス</label>
                <div>
                    <input type="text" name="email" id="email" value="{{ $customer['email'] }}"
                        class="border border-gray-300 p-2">
                    @if (isset($errMessage['email']))
                        @foreach ($errMessage['email'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col md:items-center md:flex-row mb-4">
                <label for="tel" class="w-[250px] text-lg">電話番号(ハイフンあり)</label>
                <div>
                    <input type="text" name="tel" id="tel" value="{{ $customer['tel'] }}"
                        class="border border-gray-300 p-2">
                    @if (isset($errMessage['tel']))
                        @foreach ($errMessage['tel'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col md:items-center md:flex-row mb-4">
                <label for="" class="w-[250px] text-lg">郵便番号(ハイフンあり)</label>
                <div>
                    <input type="text" name="zip" id="zip" value="{{ $customer['zip'] }}"
                        class="border border-gray-300 p-2">
                    <span class="inline-block px-4 py-2 ml-2 border border-gray-700 bg-gray-700 text-white"
                        id="postcodeBtn">住所検索</span>
                    @if (isset($errMessage['zip']))
                        @foreach ($errMessage['zip'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col md:items-center md:flex-row mb-6">
                <label for="address" class="w-[250px] text-lg">住所</label>
                <div><input type="text" name="address" id="address" value="{{ $customer['address'] }}"
                        class="border border-gray-300 p-2">
                    @if (isset($errMessage['address']))
                        @foreach ($errMessage['address'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col md:items-center md:flex-row mb-6">
                <label for="password" class="w-[250px] text-lg">パスワード</label>
                <div>
                    <input type="password" name="password" id="password" value="{{ $customer['password'] }}"
                        class="border border-gray-300 p-2">
                    <p>{{ $errMessag['password']['empty'] }}</p>
                    @if (isset($errMessage['password']))
                        @foreach ($errMessage['password'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="flex flex-col md:items-center md:flex-row mb-6">
                <label for="password_confirm" class="w-[250px] text-lg">パスワード(確認用)</label>
                <div>
                    <input type="password" name="password_confirm" id="password_confirm"
                        value="{{ $customer['password_confirm'] }}" class="border border-gray-300 p-2">
                    @if (isset($errMessage['password_confirm']))
                        @foreach ($errMessage['password_confirm'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </li>

            <input type="submit" name="send"
                class="rounded-full border border-gray-500 w-32 bg-white hover:bg-gray-700 hover:text-white px-6 py-4 hover:cursor-pointer"
                value="登録確認">
        </form>
    </section>
@endsection
