<?php

namespace App\controllers;

use App\controllers\Controller;
use HttpNotFoundException;
use Validation;

class ProductController extends Controller
{
    public function index()
    {
        // Productモデルのインスタンスを取得
        $product = $this->model->get('Product');
        // カテゴリー一覧を取得
        $categories = $product->getCategoryList();
        // 商品一覧を取得
        list($products, $paginationInfo) = $product->getProductList();
        // var_dump($paginationInfo);

        $this->view(
            'products.index',
            [
                "products" => $products,
                "categories" => $categories,
                "pagination" => $paginationInfo
            ]
        );
    }

    public function search()
    {
        // Productモデルのインスタンスを取得
        $product = $this->model->get('Product');
        // カテゴリー一覧を取得
        $categories = $product->getCategoryList();
        // 検索ワードに基づいて商品を取得
        list($products, $paginationInfo) = $product->searchProduct($_GET['q']);
        // var_dump($paginationInfo);

        if ($product !== false) {
            $this->view(
                'products.index',
                [
                    "products" => $products,
                    "categories" => $categories,
                    "pagination" => $paginationInfo
                ]
            );
        } else {
            $this->view(
                'products.index',
                [
                    "products" => $products,
                    "categories" => $categories,
                    "pagination" => $paginationInfo
                ]
            );
        }
    }

    public function show()
    {
        // Productモデルのインスタンスを取得
        $product = $this->model->get('Product');

        // 商品情報を取得する
        $id = $_GET['id'];
        $productData = $product->getProductDetailData($id);

        // レビューを取得する
        $reviews = $this->model->get('Review')->getReviews($id);

        if (\App\models\Auth::check()) {
            $favorites = $this->model->get('Product_Favorite')->getFavorites($_SESSION['customer']['id']);
        } else {
            $favorites = [];
        }

        $token = uniqid('', true);
        $_SESSION['token'] = $token;

        $this->view(
            'products.show',
            [
                "product" => $productData,
                "reviews" => $reviews,
                "favorites" => $favorites,
                "token" => $token
            ]
        );
    }

    public function create()
    {
        // Productモデルのインスタンスを取得
        $product = $this->model->get('Product');
        // カテゴリー一覧を取得
        $categories = $product->getCategoryList();

        $this->view(
            'products.create',
            [
                'categories' => $categories,
                'productData' => ['category' => []]
            ]
        );
    }

    public function confirm()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        // Productモデルのインスタンスを取得
        $product = $this->model->get('Product');
        // カテゴリー一覧を取得
        $categories = $product->getCategoryList();

        $mode = $_POST['send'];
        switch ($mode) {
            case \App\consts\CommonConst::REGISTER_CONFIRM:
                // 登録確認が押された場合
                // Formで送信された値をチェックする
                $validation = new Validation();
                list($isError, $errMessage) = $validation->validateForm([
                    'name' => 'required',
                    'price' => 'required|num',
                    'category' => 'radio',
                    'image' => 'image',
                    'detail' => 'required'
                ]);

                // var_dump($errMessage);
                // var_dump($isError);
                // var_dump($_POST);
                // var_dump($_FILES);

                if ($isError) {
                    // var_dump($errMessage);
                    $this->view(
                        'products.create',
                        [
                            'productData' => $validation->getFormData(),
                            'categories' => $categories,
                            'errMessage' => $errMessage
                        ]
                    );
                } else {
                    //二重登録を防止する
                    //session_start();
                    $token = uniqid('', true);
                    $_SESSION['token'] = $token;

                    $this->view(
                        'products.confirm',
                        [
                            'productData' => $validation->getFormData(),
                            'token' => $token
                        ]
                    );
                }

                break;
            case \App\consts\CommonConst::REGISTER_BACK:
                // 戻るを押された場合
                $this->view(
                    'products.create',
                    [
                        'productData' => $_POST,
                        'categories' => $categories
                    ]
                );
                break;
            case \App\consts\CommonConst::REGISTER_COMPLETE:
                // 登録完了を押された場合
                //session_start();
                if (isset($_POST['token']) &&  isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                    unset($_SESSION['token']);
                    $product->registerProduct();
                    // $this->view(
                    //     'products.register_complete',
                    //     []
                    // );
                    header('Location: ' . '/products');
                } else {
                    header('Location: ' . '/');
                }

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
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
    }
}
