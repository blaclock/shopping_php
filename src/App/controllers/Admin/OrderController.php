<?php

namespace App\controllers\Admin;

use App\controllers\Controller;
use HttpNotFoundException;

use function PHPUnit\Framework\throwException;

class OrderController extends Controller
{
    public function index()
    {
        if (\App\models\Auth::checkAdmin()) {
            $order = $this->model->get('Order');
            // 注文履歴データを取得
            list($orders, $orderNum, $paginationInfo) = $order->getOrderData();
            $this->view(
                'admins.orders.index',
                [
                    "orders" => $orders,
                    "orderNum" => $orderNum,
                    "pagination" => $paginationInfo,
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
                'admins.orders.top',
                []
            );
        } else {
            header('Location: ' . '/admin/login');
        }
    }

    public function show()
    {
    }
}
