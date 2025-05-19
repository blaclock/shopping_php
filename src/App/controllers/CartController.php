<?php

namespace App\controllers;

use App\controllers\Controller;
use HttpNotFoundException;
use Validation;

use function PHPUnit\Framework\throwException;

class CartController extends Controller
{
    public function index()
    {
        if (\App\models\Auth::check()) {
            $customer_id = $_SESSION['customer']['id'];
            // 顧客情報を取得
            $customer = $this->model->get('Customer')->getCustomer($customer_id);
            // カート情報を取得
            $cart = $this->model->get('Cart');
            $carts = $cart->getCartData($customer_id);
            $totalQuantity = $cart->getTotalQuantity($customer_id);
            $totalAmount = $cart->getTotalAmount($customer_id);

            $this->view(
                'carts.index',
                [
                    "carts" => $carts,
                    "totalQuantity" => $totalQuantity,
                    "totalAmount" => $totalAmount,
                    "customer" => $customer,
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

    public function store()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }
        if (\App\models\Auth::check()) {
            $customer_id = $_SESSION['customer']['id'];
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            if (isset($_POST['token']) &&  isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                unset($_SESSION['token']);
                $cart = $this->model->get('Cart');
                $cart->addCart($customer_id, $product_id, $quantity);
                header('Location: ' . '/cart');
            } else {
                header('Location: ' . '/product?id=' . $product_id);
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
        echo ';fja;jdfa;';
        if (\App\models\Auth::check()) {
            $cart = $this->model->get('Cart');
            $cart->updateCart();
            header('Location: ' . '/cart');
        } else {
            header('Location: ' . '/login');
        }
    }

    public function destroy()
    {
        $cart_id = $_GET['cart_id'];
        $cart = $this->model->get('Cart');
        $cart->deleteCart($cart_id);
        header('Location: ' . '/cart');
    }
}
