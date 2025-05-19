@extends('layouts.admin.app')

@section('content')
    <form action="" method="post" enctype="multipart/form-data">
        <div class="flex">
            <span>ファイル</span>
            <input type="radio" name="csv" value="import" id="import">
            <label for="import">インポート</label>
            <input type="radio" name="csv" value="export" id="exort">
            <label for="export">エクスポート</label>
        </div>
    </form>
@endsection
