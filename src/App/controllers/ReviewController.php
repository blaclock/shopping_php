<?php

namespace App\controllers;

use App\controllers\Controller;
use HttpNotFoundException;
use Validation;

class ReviewController extends Controller
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
        $review = $this->model->get('Review');
        $this->view(
            'customers.show',
            [
                'customer' => $review->getReview($_SESSION['customer']['id'])
            ]
        );
    }

    public function create()
    {
        if (\App\models\Auth::check()) {
            // Productモデルのインスタンスを取得
            $product = $this->model->get('Product')->getProductDetailData($_GET['product_id']);

            $token = uniqid('', true);
            $_SESSION['token'] = $token;

            $this->view(
                'reviews.create',
                [
                    'product' => $product,
                    'token' => $token
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

        $validation = new Validation();
        list($isError, $errMessage) = $validation->validateForm([
            'title' => 'required',
            'content' => 'required',
            'score' => 'radio'
        ]);

        if ($isError) {
            $this->view(
                'reviews.create',
                [
                    'review' => $_POST,
                    'errMessage' => $errMessage
                ]
            );
        } else {
            $customer_id = $_SESSION['customer']['id'];
            $product_id = $_POST['product_id'];
            if (isset($_POST['token']) &&  isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                unset($_SESSION['token']);
                $review = $this->model->get('Review');
                $review->postReview($customer_id, $product_id);
                // header('Location: ' . '/register/completed');
                header('Location: ' . '/product?id=' . $product_id);
            } else {
                header('Location: ' . '/product?id=' . $product_id);
            }
        }
    }

    public function edit()
    {
        if (\App\models\Auth::check()) {
            $review = $this->model->get('Review');
            $this->view(
                'customers.edit',
                [
                    'customer' => $review->getReview($_SESSION['customer']['id'])
                ]
            );
        }
    }

    public function destroy()
    {
        //session_start();
        $this->model->get('Review')->deleteReview($_SESSION['customer']['id']);
        $this->view(
            'customers.withdraw',
            []
        );
    }
}
