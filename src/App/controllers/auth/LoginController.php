<?php

namespace App\controllers;

use App\controllers\Controller;
use \HttpNotFoundException;
use Validation;
// メール関連
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


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
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        $validation = new Validation();
        list($isError, $errMessage) = $validation->validateForm([
            'email' => 'required|email|unique:customers'
        ]);

        // バリデーションの結果が重複のみエラー（メールアドレスが存在すれば）
        if (count($errMessage['email']) === 1 && isset($errMessage['email']['unique'])) {
            $email = $_POST['email'];
            $yourPassword = $this->model->get('Customer')->confirmPassword($email);

            $mail = new PHPMailer(true);

            try {
                //Gmail 認証情報
                $host = 'smtp.gmail.com';
                $username = 'blaclock@gmail.com'; // example@gmail.com
                $password = 'dfzynjllhobfuudc';

                //差出人
                $from = 'blaclock@gmail.com';
                $fromName = '黒岩知宏';

                //宛先
                $to = $email;
                $toName = '宛名';

                //件名・本文
                $subject = 'パスワード確認';
                $body = 'あなたのパスワードは、' . $yourPassword . 'です。';

                //メール設定
                $mail->SMTPDebug = 2; //デバッグ用
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->Host = $host;
                $mail->Username = $username;
                $mail->Password = $password;
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->CharSet = "utf-8";
                $mail->Encoding = "base64";
                $mail->setFrom($from, $fromName);
                $mail->addAddress($to, $toName);
                $mail->Subject = $subject;
                $mail->Body    = $body;

                //メール送信
                $mail->send();

                header('Location: ' . '/login');
            } catch (Exception $e) {
                echo '失敗: ', $mail->ErrorInfo;
            }
        } else {
            $errMessage['email']['unique'] = '入力されたメールアドレスは登録されていません';
            var_dump($errMessage);
            $this->view(
                'auth.login.confirm_password',
                [
                    'errMessage' => $errMessage
                ]
            );
        }
    }
}
