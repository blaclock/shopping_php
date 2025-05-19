<?php

namespace App\controllers\Admin;

use App\controllers\Controller;
use HttpNotFoundException;
use Validation;

class AdminController extends Controller
{

    public function index()
    {
        if (\App\models\Auth::checkAdmin()) {
            $admin = $this->model->get('Admin');

            $admins = $admin->getAdmins();

            $this->view(
                'admins.admins.index',
                [
                    'admins' => $admins
                ]
            );
        } else {
            header('Location: ' . '/admin/login');
        }
    }

    public function top()
    {
        if (\App\models\Auth::checkAdmin()) {
            $this->view(
                'admins.admins.top',
                []
            );
        } else {
            header('Location: ' . '/admin/login');
        }
    }

    public function show()
    {
        if (\App\models\Auth::checkAdmin()) {
            $admin = $this->model->get('Admin');
            $this->view(
                'admins.admins.show',
                [
                    'admin' => $admin->getAdmin($_GET['id'])
                ]
            );
        } else {
            header('Location: ' . '/admin/login');
        }
    }

    public function destroy()
    {
        if (\App\models\Auth::checkAdmin()) {
            //session_start();
            $this->model->get('Admin')->deleteAdmin($_GET['admin_id']);
            header('Location: ' . '/admin/admins');
            // $this->view(
            //     'admins.withdraw',
            //     []
            // );
        } else {
            throw new HttpNotFoundException();
        }
    }
}
