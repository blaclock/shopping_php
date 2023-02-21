@extends('layouts.app')

@section('content')
    <section class="text-gray-600 body-font">
        <div>
            <div class="mx-auto mt-8 lg:w-120 p-8 border border-gray-300">
                <h5 class="mb-8 text-center font-bold">管理者ログイン</h5>
                @if (isset($loginError))
                    <p class="mb-4 text-red-500">メールアドレス、もしくはパスワードに誤りがあります。</p>
                @endif
                <form action="/admin/login/confirm" method="post" class="mx-auto">
                    <div class="flex items-center mb-6">
                        <label for="email" class="w-1/3">メールアドレス</label>
                        <input type="email" name="email" id="email" value="{{ $email }}"
                            class="w-2/3 h-8 px-2 border border-gray-500">
                    </div>
                    <div class="flex items-center mb-8">
                        <label for="password" class="w-1/3">パスワード</label>
                        <input type="password" name="password" id="password" class="w-2/3 h-8 px-2 border border-gray-500">
                    </div>
                    <div class="text-center">
                        <button type="submit" value="ログイン"
                            class="rounded-full border border-gray-500 w-48 px-8 py-4 bg-white hover:bg-gray-700 hover:text-white">ログイン</button>
                    </div>
                </form>
                <p class="flex flex-col items-center mt-4">
                    <a href="/password/confirm" class="underline hover:opacity-80">パスワードをお忘れの方はこちら</a>
                </p>
            </div>
        </div>
    </section>
@endsection
