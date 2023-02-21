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

    public function exportCSV($table)
    {
        $filePath = '/tmp/export.csv';
        $model = new Model();

        $res = $model->db->export($table, $filePath);
        if ($res === false) {
            echo 'ファイルのエクスポートに失敗しました<br>';
            return;
        }

        $filePath = \App\consts\CommonConst::RESOURCE_DIR . 'csv/export.csv';
        header('Content-Type: text/csv');
        header('Content-Length: ' . filesize($filePath));
        header('Content-Disposition:attachment;filename = export.csv');
        readfile($filePath);
        unlink($filePath);
        exit;
    }
}
