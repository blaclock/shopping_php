<?php

namespace App\models;

use \HttpNotFoundException;

class Review extends Model
{
    public function postReview($customer_id = '', $product_id = '')
    {
        $insData = [
            'customer_id' => $customer_id,
            'product_id' => $product_id,
            'title' => $_POST['title'],
            'content' => $_POST['content']
        ];

        $res = $this->db->insert('reviews', $insData);
    }

    public function getReviews($product_id)
    {
        $table = ' reviews AS r 
                    INNER JOIN customers AS c
                        ON r.customer_id = c.id
                    INNER JOIN products as p
                        ON r.product_id = p.id ';
        $col = ' c.account_name, r.created_at, r.title, r.content ';

        $where = ($product_id !== '') ? ' r.product_id = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($product_id !== '') ? [$product_id] : [];

        $this->db->setOrder('created_at DESC');

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? $res : false;
    }

    public function updateReview($review_id)
    {
        $table = ' reviews ';

        // 更新時間を取得
        $update_time = date('Y-m-d H:i:s');

        $insData = [
            'email' => $_POST['email'],
            'tel' => $_POST['tel'],
            'zip' => $_POST['zip'],
            'address' => $_POST['address'],
            'updated_at' => $update_time
        ];

        $where = ' id = ? ';
        $arrVal = [$review_id];

        $res = $this->db->update($table, $insData, $where, $arrVal);
    }

    public function deleteReview($review_id)
    {
        $table = ' reviews ';
        $where = ' id = ? ';
        $this->db->delete($table, $where, [$review_id]);
    }
}
