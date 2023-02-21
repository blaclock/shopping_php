@extends('layouts.admin.app')

@section('content')
    <div>
        <a class="rounded-full border border-gray-500 w-32 bg-white hover:bg-gray-700 hover:text-white px-6 py-4 hover:cursor-pointer"
            href="/admin/csv_export/execute?data={{ $data }}">エクスポート</a>
    </div>
@endsection
