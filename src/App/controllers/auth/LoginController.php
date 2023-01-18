<?php

namespace App\controllers;

use App\controllers\Controller;

class LoginController extends Controller
{
    public function index()
    {
        //session_start();
        if (isset($_SESSION['customer'])) {
            header('Location: ' . '/mypage');
        } else {
            $this->view(
                'auth.login.index',
                []
            );
        }
    }

    public function confirm()
    {
        $customer = $this->model->get('Auth');
        if ($customer->login() !== false) {
            header('Location: ' . '/mypage');
        } else {
            $this->view(
                'auth.login.index',
                [
                    'email' => $_POST['email'],
                    'loginError' => true
                ]
            );
        }
    }

    public function show()
    {
        //session_start();
        $this->view(
            'auth.login.show',
            []
        );
    }

    public function logout()
    {
        \App\models\Auth::logout();
    }

    public function confirmPassword()
    {
        $this->view(
            'auth.login.confirm_password',
            []
        );
    }

    public function sendPassword()
    {
        $email = $_POST['email'];
        var_dump($email);
        $password = $this->model->get('Customer')->confirmPassword($email);
        $to = $email;
        $subject = "パスワード送信";
        $message = "あなたのパスワードは、{$password}です";
        var_dump($message);
        $headers = "From: blaclock@gmail.com";
        mb_send_mail($to, $subject, $message, $headers);
    }
}
