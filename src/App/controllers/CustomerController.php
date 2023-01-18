<?php

namespace App\controllers;

use App\controllers\Controller;
use HttpNotFoundException;
use Validation;

class CustomerController extends Controller
{

    public function index()
    {
        //session_start();
        if (isset($_SESSION['customer'])) {
            $this->view(
                'customers.index',
                []
            );
        } else {
            header('Location: ' . '/login');
        }
    }

    public function show()
    {
        //session_start();
        $customer = $this->model->get('Customer');
        $this->view(
            'customers.show',
            [
                'customer' => $customer->getCustomer($_SESSION['customer']['id'])
            ]
        );
    }

    public function create()
    {
        // Productモデルのインスタンスを取得
        $customer = $this->model->get('Customer');
        // カテゴリー一覧を取得

        $this->view(
            'customers.create',
            []
        );
    }

    public function confirm()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        // Productモデルのインスタンスを取得
        $customer = $this->model->get('Product');
        // カテゴリー一覧を取得
        $categories = $customer->categories;

        $mode = $_POST['send'];
        switch ($mode) {
            case \App\consts\CommonConst::REGISTER_CONFIRM:
                // 登録確認が押された場合
                // Formで送信された値をチェックする
                $validation = new Validation();
                list($isError, $errMessage) = $validation->validateForm([
                    'name' => 'required',
                    'price' => 'required|num',
                    'detail' => 'required'
                ]);

                // var_dump($errMessage);
                // var_dump($isError);

                if ($isError) {
                    $this->view(
                        '$customers.create',
                        [
                            '$customerData' => $_POST,
                            'categories' => $categories,
                            'errMessage' => $errMessage
                        ]
                    );
                } else {
                    $this->view(
                        '$customers.confirm',
                        [
                            '$customerData' => $_POST,
                        ]
                    );
                }

                break;
            case \App\consts\CommonConst::REGISTER_BACK:
                // 戻るを押された場合
                $this->view(
                    '$customers.create',
                    [
                        '$customerData' => $_POST,
                        'categories' => $categories
                    ]
                );
                break;
            case \App\consts\CommonConst::REGISTER_COMPLETE:
                // 登録完了を押された場合
                break;
            default:
                break;
        }
    }

    public function store()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        $customer = $this->model->get('Customer');

        $mode = $_POST['send'];
        switch ($mode) {
            case \App\consts\CommonConst::REGISTER_CONFIRM:
                // 登録確認が押された場合
                // Formで送信された値をチェックする
                $validation = new Validation();
                list($isError, $errMessage) = $validation->validateForm([
                    'email' => 'required|email',
                ]);

                if ($isError) {
                    // var_dump($errMessage);
                    // var_dump($_POST);
                    $this->view(
                        'customers.create',
                        [
                            'customer' => $_POST,
                            'errMessage' => $errMessage
                        ]
                    );
                } else {
                    //session_start();
                    $token = uniqid('', true);
                    $_SESSION['token'] = $token;
                    $this->view(
                        'customers.register_confirm',
                        [
                            'customer' => $_POST,
                            'token' => $token
                        ]
                    );
                }

                break;
            case \App\consts\CommonConst::REGISTER_BACK:
                // 戻るを押された場合
                $this->view(
                    'customers.create',
                    [
                        'customer' => $_POST,
                    ]
                );
                break;
            case \App\consts\CommonConst::REGISTER_COMPLETE:
                // 更新するを押された場合
                //session_start();
                if (isset($_POST['token']) &&  isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                    unset($_SESSION['token']);
                    $customer->registerCustomer();
                    // header('Location: ' . '/register/completed');
                    $this->view(
                        'customers.register_complete',
                        []
                    );
                    $customer = $this->model->get('Auth')->login();
                } else {
                    header('Location: ' . '/login');
                }
                break;
            default:
                break;
        }
    }

    public function edit()
    {
        if (\App\models\Auth::check()) {
            $customer = $this->model->get('Customer');
            $this->view(
                'customers.edit',
                [
                    'customer' => $customer->getCustomer($_SESSION['customer']['id'])
                ]
            );
        }
    }

    public function update()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        // Customerモデルのインスタンスを取得
        $customer = $this->model->get('Customer');

        $mode = $_POST['send'];
        switch ($mode) {
            case \App\consts\CommonConst::UPDATE_CONFIRM:
                // 登録確認が押された場合
                // Formで送信された値をチェックする
                $validation = new Validation();
                list($isError, $errMessage) = $validation->validateForm([
                    'email' => 'required|email',
                ]);

                if ($isError) {
                    // var_dump($errMessage);
                    // var_dump($_POST);
                    $this->view(
                        'customers.edit',
                        [
                            'customer' => $_POST,
                            'errMessage' => $errMessage
                        ]
                    );
                } else {
                    // var_dump($_POST);
                    //session_start();
                    $token = uniqid('', true);
                    $_SESSION['token'] = $token;
                    $this->view(
                        'customers.update_confirm',
                        [
                            'customer' => $_POST,
                            'token' => $token
                        ]
                    );
                }

                break;
            case \App\consts\CommonConst::REGISTER_BACK:
                // 戻るを押された場合
                $this->view(
                    'customers.edit',
                    [
                        'customer' => $_POST,
                    ]
                );
                break;
            case \App\consts\CommonConst::UPDATE_COMPLETE:
                // 更新するを押された場合
                //session_start();
                if (isset($_POST['token']) &&  isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                    unset($_SESSION['token']);
                    $customer->updateCustomer($_SESSION['customer']['id']);
                    header('Location: ' . '/mypage');
                } else {
                    header('Location: ' . '/mypage/detail');
                }
                break;
            default:
                break;
        }
    }

    public function destroy()
    {
        if (\App\models\Auth::check()) {
            //session_start();
            $this->model->get('Customer')->deleteCustomer($_SESSION['customer']['id']);
            $this->view(
                'customers.withdraw',
                []
            );
        } else {
            throw new HttpNotFoundException();
        }
    }
}
