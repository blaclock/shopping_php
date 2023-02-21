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
            if (isset($_POST['token']) &&  isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                unset($_SESSION['token']);
                $customer_id = $_SESSION['customer']['id'];
                $order = $this->model->get('Order');
                // 注文データを格納
                $order->addOrder($customer_id);

                // カートから注文され商品を削除する
                $cart_id = $_POST['cart_id'];
                $this->model->get('Cart')->orderedCart($cart_id);
                header('Location: ' . '/mypage/orders');
            } else {
                header('Location: ' . '/cart');
            }
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
            if (isset($_POST['token']) &&  isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                unset($_SESSION['token']);
                $customer_id = $_SESSION['customer']['id'];
                $order = $this->model->get('Order');
                // 注文データを格納
                $order->addOrder($customer_id);

                // カートから注文され商品を削除する
                $cart_id = $_POST['cart_id'];
                $this->model->get('Cart')->orderedCart($cart_id);
                header('Location: ' . '/mypage/orders');
            } else {
                header('Location: ' . '/cart');
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
