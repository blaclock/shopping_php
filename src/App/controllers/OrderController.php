<?php

namespace App\controllers;

use App\controllers\Controller;
use HttpNotFoundException;
use Validation;

use function PHPUnit\Framework\throwException;

class OrderController extends Controller
{
    public function index()
    {
        if (\App\models\Auth::check()) {
            $customer_id = $_SESSION['customer']['id'];
            $order = $this->model->get('Order');
            // 注文履歴データを取得
            list($orders, $orderNum, $paginationInfo) = $order->getOrderData($customer_id);
            $this->view(
                'orders.index',
                [
                    "orders" => $orders,
                    "orderNum" => $orderNum,
                    "pagination" => $paginationInfo,
                ]
            );
        } else {
            header('Location: ' . '/login');
        }
    }

    public function show()
    {
    }

    public function create()
    {
    }

    public function confirm()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        if (\App\models\Auth::check()) {
            $customer_id = $_SESSION['customer']['id'];
            // 顧客情報を取得
            $customer = $this->model->get('Customer')->getCustomer($customer_id);
            // カート情報を取得
            $cart = $this->model->get('Cart');
            $carts = $cart->getCartData($customer_id);
            $totalQuantity = $cart->getTotalQuantity($customer_id);
            $totalAmount = $cart->getTotalAmount($customer_id);
            // 二重送信を防止
            $token = uniqid('', true);
            $_SESSION['token'] = $token;
            $this->view(
                'orders.confirm',
                [
                    "carts" => $carts,
                    "totalQuantity" => $totalQuantity,
                    "totalAmount" => $totalAmount,
                    "customer" => $customer,
                    "token" => $token
                ]
            );
        } else {
            header('Location: ' . '/login');
        }
    }

    public function store()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        if (\App\models\Auth::check()) {
            // 登録確認が押された場合
            // Formで送信された値をチェックする
            $validation = new Validation();
            list($isError, $errMessage) = $validation->validateForm([
                'zip' => 'required|zip',
                'delivery_to' => 'required',
                'payment_type' => 'radio'
            ]);

            // var_dump($errMessage);
            // var_dump($isError);
            // var_dump($_POST);
            // var_dump($_FILES);

            if ($isError) {
                // var_dump($errMessage);
                $customer_id = $_SESSION['customer']['id'];
                // 顧客情報を取得
                $customer = $this->model->get('Customer')->getCustomer($customer_id);
                // カート情報を取得
                $cart = $this->model->get('Cart');
                $carts = $cart->getCartData($customer_id);
                $totalQuantity = $cart->getTotalQuantity($customer_id);
                $totalAmount = $cart->getTotalAmount($customer_id);
                // 二重送信を防止
                $token = uniqid('', true);
                $_SESSION['token'] = $token;
                $this->view(
                    'orders.confirm',
                    [
                        "carts" => $carts,
                        "totalQuantity" => $totalQuantity,
                        "totalAmount" => $totalAmount,
                        "customer" => $customer,
                        "errMessage" => $errMessage,
                        "token" => $token
                    ]
                );
            } else {
                if (isset($_POST['token']) &&  isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                    unset($_SESSION['token']);
                    $customer_id = $_SESSION['customer']['id'];
                    $customer = $this->model->get('Customer')->getCustomer($customer_id);
                    $order = $this->model->get('Order');
                    // 注文データを格納
                    $order->addOrder($customer_id);

                    // カートから注文され商品を削除する
                    $cart_id = $_POST['cart_id'];
                    $cart = $this->model->get('Cart');
                    $cart->orderedCart($cart_id);
                    $this->view(
                        'orders.thanks',
                        []
                    );

                    // 購入商品をメールで通知する
                    $order->informOrders($customer);
                } else {
                    header('Location: ' . '/cart');
                }
            }
        } else {
            header('Location: ' . '/login');
        }
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
        $order_id = $_GET['order_id'];
        $order = $this->model->get('Order');
        $order->deleteOrder($order_id);
        header('Location: ' . '/order');
    }
}
