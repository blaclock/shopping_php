<?php

namespace App\controllers\Admin;

use App\controllers\Controller;
use HttpNotFoundException;
use Validation;

class ProductController extends Controller
{
    public function index()
    {
        // 管理者ログインしていたら
        if (\App\models\Auth::checkAdmin()) {
            // Productモデルのインスタンスを取得
            $product = $this->model->get('Product');

            // 商品一覧を取得
            list($products, $productNum, $paginationInfo) = $product->getProductList();

            $this->view(
                'admins.products.index',
                [
                    'products' => $products,
                    'productNum' => $productNum,
                    'pagination' => $paginationInfo
                ]
            );
        } else {
            header("Location: " . "/admin/login");
        }
    }

    public function top()
    {
        // 管理者ログインしていたら
        if (\App\models\Auth::checkAdmin()) {
            $this->view(
                'admins.products.top',
                []
            );
        } else {
            header("Location: " . "/admin/login");
        }
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
                'admins.products.index',
                [
                    'products' => $products,
                    'categories' => $categories,
                    'pagination' => $paginationInfo
                ]
            );
        } else {
            $this->view(
                'admins.products.index',
                [
                    'products' => $products,
                    'categories' => $categories,
                    'pagination' => $paginationInfo
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
            $favorites = $this->model->get('Product_Favorite')->getFavorites($_SESSION['product']['id']);
        } else {
            $favorites = [];
        }

        $token = uniqid('', true);
        $_SESSION['token'] = $token;

        $this->view(
            'admins.products.show',
            [
                'product' => $productData,
                'reviews' => $reviews,
                'favorites' => $favorites,
                'token' => $token
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
            'admins.products.create',
            [
                'categories' => $categories,
                'productData' => ['category' => []]
            ]
        );
    }

    public function store()
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

                if ($isError) {
                    // var_dump($errMessage);
                    // $productData = $_POST;
                    $productData = $validation->getFormData();
                    // var_dump($productData);
                    $this->view(
                        'admins.products.create',
                        [
                            'productData' => $productData,
                            'categories' => $categories,
                            'errMessage' => $errMessage
                        ]
                    );
                } else {
                    //二重登録を防止する
                    //session_start();
                    $token = uniqid('', true);
                    $_SESSION['token'] = $token;

                    $productData = $validation->getFormData();
                    $this->view(
                        'admins.products.confirm',
                        [
                            'productData' => $productData,
                            'categories' => $categories,
                            'token' => $token
                        ]
                    );
                }

                break;
            case \App\consts\CommonConst::REGISTER_BACK:
                // 戻るを押された場合
                $this->view(
                    'admins.products.create',
                    [
                        'productData' => $_POST,
                        'categories' => $categories
                    ]
                );
                break;
            case \App\consts\CommonConst::REGISTER_COMPLETE:
                // 登録完了を押された場合
                if (isset($_POST['token']) &&  isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                    unset($_SESSION['token']);
                    $product = $this->model->get('Product');
                    $product->registerProduct();
                    // $this->view(
                    //     'admins.products.register_complete',
                    //     []
                    // );
                    header('Location: ' . '/admin/products');
                } else {
                    header('Location: ' . '/admin');
                }

                break;
            default:
                break;
        }
    }

    public function edit()
    {
        if (\App\models\Auth::checkAdmin()) {
            // Productモデルのインスタンスを取得
            $product = $this->model->get('Product');
            // カテゴリー一覧を取得
            $categories = $product->getCategoryList();

            // 商品情報を取得する
            $id = $_GET['id'];
            $productData = $product->getProductDetailData($id);

            $token = uniqid('', true);
            $_SESSION['token'] = $token;

            $this->view(
                'admins.products.edit',
                [
                    'productData' => $productData,
                    'categories' => $categories,
                    'token' => $token
                ]
            );
        } else {
            header("Location: " . "/admin/login");
        }
    }


    public function update()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        // Customerモデルのインスタンスを取得
        $product = $this->model->get('Product');
        // カテゴリー一覧を取得
        $categories = $product->getCategoryList();

        $mode = $_POST['send'];
        switch ($mode) {
            case \App\consts\CommonConst::UPDATE_CONFIRM:
                // 登録確認が押された場合
                // Formで送信された値をチェックする
                $validation = new Validation();
                list($isError, $errMessage) = $validation->validateForm([
                    'name' => 'required',
                    'price' => 'required|num',
                    'category_id' => 'radio',
                    'image' => 'image:update',
                    'detail' => 'required'
                ]);

                if ($isError) {
                    $productData = $validation->getFormData();
                    $productData = $_POST;
                    // var_dump($productData);
                    var_dump($_POST);
                    $this->view(
                        'admins.products.edit',
                        [
                            'productData' => $_POST,
                            'categories' => $categories,
                            'errMessage' => $errMessage
                        ]
                    );
                } else {
                    //session_start();
                    $token = uniqid('', true);
                    $_SESSION['token'] = $token;
                    $productData = $validation->getFormData();
                    $this->view(
                        'admins.products.update_confirm',
                        [
                            'productData' => $productData,
                            'categories' => $categories,
                            'token' => $token
                        ]
                    );
                }

                break;
            case \App\consts\CommonConst::REGISTER_BACK:
                // 戻るを押された場合
                // var_dump($_POST);
                $this->view(
                    'admins.products.edit',
                    [
                        'productData' => $_POST,
                        'categories' => $categories
                    ]
                );
                break;
            case \App\consts\CommonConst::UPDATE_COMPLETE:
                // 更新するを押された場合
                //session_start();
                if (isset($_POST['token']) &&  isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                    // var_dump($_POST);
                    unset($_SESSION['token']);
                    $product->updateProduct($_POST['id']);
                    header('Location: ' . '/admin/products');
                } else {
                    header('Location: ' . '/admin');
                }
                break;
            default:
                break;
        }
    }

    public function destroy()
    {
        $product = $this->model->get('Product');
        $product->deleteProduct($_GET['id']);
        header('Location: ' . '/admin/products');
    }

    public function CSV()
    {
        $this->view(
            'admins.products.csv',
            []
        );
    }
    public function importCSV()
    {
    }
    public function exportCSV()
    {
    }
}
