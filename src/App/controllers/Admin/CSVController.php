<?php

namespace App\controllers\Admin;

use App\controllers\Controller;
use HttpNotFoundException;
use Validation;
use App\core\CSV;

class CSVController extends Controller
{
    public function top()
    {
        if (\App\models\Auth::checkAdmin()) {
            $data = $_GET['data'];
        } else {
            header('Location: ' . '/admin/login');
        }
    }

    public function import()
    {
        if (\App\models\Auth::checkAdmin()) {
            $data = $_GET['data'];
            $this->view(
                'admins.csv.import',
                ['data' => $data]
            );
        } else {
            header('Location: ' . '/admin/login');
        }
    }

    public function store()
    {
        if (\App\models\Auth::checkAdmin()) {

            $data = $_POST['data'];
            $validation = new Validation();
            list($isError, $errMessage) = $validation->validateForm([
                'csv' => 'csv',
            ]);

            if ($isError) {
                // var_dump($errMessage);
                $this->view(
                    'admins.csv.import',
                    [
                        'data' => $data,
                        'errMessage' => $errMessage
                    ]
                );
            } else {
                $token = uniqid('', true);
                $_SESSION['token'] = $token;
                $csv = new CSV();
                $csv->importCSV($data);

                $this->view(
                    'admins.csv.import',
                    [
                        'data' => $data,
                    ]
                );
            }
        } else {
            header('Location: ' . '/admin/login');
        }
    }

    public function export()
    {
        if (\App\models\Auth::checkAdmin()) {
            $data = $_GET['data'];

            $this->view(
                'admins.csv.export',
                [
                    'data' => $data,
                ]
            );
        } else {
            header('Location: ' . '/admin/login');
        }
    }

    public function download()
    {
        if (\App\models\Auth::checkAdmin()) {
            $table = $_GET['data'];
            $data = $this->model->get($table);
            $data->exportCSV();
        } else {
            header('Location: ' . '/admin/login');
        }
    }
}
