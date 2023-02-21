@extends('layouts.admin.app')

@push('js')
    <script src="{{ App\consts\CommonConst::JS_PATH }}csv_upload.js"></script>
@endpush

@section('content')
    <div>
        <form action="/admin/csv_import/execute" method="post" enctype="multipart/form-data" class="">
            <input type="hidden" name="data" value="{{ $data }}">
            <div class="flex justify-center items-center mb-5 w-2/3 h-[300px] border border-dashed border-gray-700"
                id="drop-zone">
                <div class="text-center">
                    <p class="mb-2">ファイルをドラッグ＆ドロップしてください<br>もしくは</p>
                    <input type="file" name="csv" id="csv" class="hidden">
                    <label for="csv"
                        class="inline-block mx-auto py-2 px-2 border border-gray-300 bg-white hover:bg-gray-700 hover:text-white duration-200">ファイルを選択</label>
                    <p id="file-name"></p>
                    @if (isset($errMessage))
                        @foreach ($errMessage['csv'] as $error)
                            <p class="text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <input type="submit" name="send" value="インポート"
                class="rounded-full border border-gray-500 w-32 bg-white hover:bg-gray-700 hover:text-white px-6 py-4 hover:cursor-pointer">
        </form>
    </div>
@endsection
