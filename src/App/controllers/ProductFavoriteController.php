<?php

namespace App\controllers;

class ProductFavoriteController extends Controller
{
    public function index()
    {
        if (\App\models\Auth::check()) {
            $favorites = $this->model->get('Product_Favorite')->getFavoritesList($_SESSION['customer']['id']);
            $this->view(
                'customers.favorites',
                [
                    'favorites' => $favorites
                ]
            );
        } else {
            header('Location: ' . '/login');
        }
    }

    public function store()
    {
        $product_id = $_GET['product_id'];
        if (\App\models\Auth::check()) {
            $this->model->get('Product_Favorite')->addFavorite($_SESSION['customer']['id'], $product_id);
            header('Location: ' . '/product?id=' . $product_id);
        } else {
            header('Location: ' . '/login');
        }
    }

    public function destroy()
    {
        $product_id = $_GET['product_id'];
        if (\App\models\Auth::check()) {
            $this->model->get('Product_Favorite')->removeFavorite($_SESSION['customer']['id'], $product_id);
            header('Location: ' . '/product?id=' . $product_id);
        } else {
            header('Location: ' . '/login');
        }
    }
}
