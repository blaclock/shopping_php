<?php

namespace App\core;

use App\models\Model;

class CSV extends Model
{
    public function importCSV($table)
    {
        $fileName = $_FILES['csv']['name'];
        $filePath = '/tmp/' . $fileName;
        $model = new Model();

        $res = $model->db->import($table, $filePath);
        if ($res === false) {
            echo 'ファイルのインポートに失敗しました<br>';
            return;
        }

        $filePath = \App\consts\CommonConst::RESOURCE_DIR . 'csv/' . $fileName;
        unlink($filePath);
    }

    public static function export($list)
    {
        // ファイルを開く
        $fp = fopen(\App\consts\CommonConst::RESOURCE_DIR . 'csv/export.csv', 'w');
        // 1行ずつ配列の内容をファイルに書き込む
        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }
        // ファイルを閉じる
        fclose($fp);

        $filePath = \App\consts\CommonConst::RESOURCE_DIR . 'csv/export.csv';
        header('Content-Type: text/csv');
        header('Content-Length: ' . filesize($filePath));
        header('Content-Disposition:attachment;filename = export.csv');
        readfile($filePath);
        unlink($filePath);
        exit;
    }
}
