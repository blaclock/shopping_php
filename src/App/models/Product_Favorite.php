<?php

namespace App\models;

use \HttpNotFoundException;

class Product_Favorite extends Model
{
    public function addFavorite($customer_id = '', $product_id = '')
    {
        if ($customer_id !== '' && $product_id !== '') {
            $insData = [
                'customer_id' => $customer_id,
                'product_id' => $product_id
            ];

            $res = $this->db->insert('product_favorites', $insData);
        }
    }

    public function removeFavorite($customer_id = '', $product_id = '')
    {
        $product_id = (int)$product_id;
        if ($customer_id !== '' && $product_id !== '') {
            $table = ' product_favorites ';
            $where = ($customer_id !== '' && $product_id !== '') ? ' customer_id = ? AND product_id = ? ' : '';
            $arrVal = ($customer_id !== '' && $product_id !== '') ? [$customer_id, $product_id] : [];
            $res = $this->db->delete($table, $where, $arrVal);
            var_dump($res);
        }
    }

    private function isFavorite($customer_id = '', $product_id = '')
    {
        $table = ' product_favorites ';
        $col = ' product_id ';
        $where = ($customer_id !== '' && $product_id !== '') ? ' customer_id = ?, customer_id = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($customer_id !== '' && $product_id !== '') ? [$customer_id, $product_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? true : false;
    }

    public function getFavoritesList($customer_id)
    {
        $table = ' product_favorites AS pf INNER JOIN products AS pr ON pf.product_id = pr.id ';
        $col = ' pf.product_id, pr.name, pr.image ';

        $where = ($customer_id !== '') ? ' customer_id = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($customer_id !== '') ? [$customer_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? $res : false;
        // if (count($res) !== 0) {
        //     $favorites = [];
        //     foreach ($res as $val) {
        //         $favorites[] = $val['product_id'];
        //     }
        //     return $favorites;
        // } else {
        //     return [];
        // }
    }

    public function getFavorites($customer_id)
    {
        $table = ' product_favorites ';
        $col = ' product_id ';

        $where = ($customer_id !== '') ? ' customer_id = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($customer_id !== '') ? [$customer_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);
        if (count($res) !== 0) {
            $favorites = [];
            foreach ($res as $val) {
                $favorites[] = $val['product_id'];
            }
            return $favorites;
        } else {
            return [];
        }
    }
}
