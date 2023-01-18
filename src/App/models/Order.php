<?php

namespace App\models;

class Order extends Model
{
    // カートに登録する(必要な情報は、誰が$customer_id、何を($item_id))
    public function addOrder($customer_id, $product_id, $quantity)
    {
        // 注文テーブルにレコードを挿入
        $table = ' orders ';
        $insData = ['customer_id' => $customer_id];
        $this->db->insert($table, $insData);
        $order_id = $this->db->getLastId();

        // 注文明細テーブルにレコードを挿入
        $table = ' order_details ';
        foreach ($product_id as $key => $val) {
            $insData = [
                'order_id' => $order_id,
                'product_id' => $val,
                'quantity' => $quantity[$key]
            ];
            $this->db->insert($table, $insData);
        }
    }

    // カートの情報を取得する(必要な情報は、誰が$customer_id。必要な商品情報は名前、商品画像、金額)
    public function getOrderData($customer_id)
    {
        $table = ' orders AS o 
                    INNER JOIN order_details AS od 
                        ON o.id = od.order_id
                    INNER JOIN products AS p 
                        ON od.product_id = p.id ';
        $column = ' o.id, od.product_id, p.name, od.quantity, p.price, p.image, o.created_at ';
        $where = ' o.customer_id = ? AND o.delete_flg = ? ';
        $arrVal = [$customer_id, 0];

        $res = $this->db->select($table, $column, $where, $arrVal);
        return (count($res) !== 0) ? $res : false;
    }

    // カート情報を削除する：必要な情報はどのカートを($crt_id)
    public function deleteOrder($order_id)
    {
        $table = ' orders ';
        $insData = ['delete_flg' => 1];
        $where = ' id = ? ';
        $arrWhereVal = [$order_id];

        return $this->db->update($table, $insData, $where, $arrWhereVal);
    }

    // アイテム数と合計金額を取得する
    public function getTotalQuantity($customer_id)
    {
        $table = ' orders ';
        $column = ' SUM( num ) AS total_quantity ';
        $where = ' customer_id = ? AND delete_flg = ? ';
        $arrWhereVal = [$customer_id, 0];
        $res = $this->db->select($table, $column, $where, $arrWhereVal);

        return ($res !== false && count($res) !== 0) ? $res[0]['total_quantity'] : 0;
    }

    // アイテム数と合計金額を取得する
    public function getTotalAmount($customer_id)
    {
        $table = ' orders c INNER JOIN products p ON c.product_id = p.id ';
        $column = ' SUM( p.price * c.num ) AS totalPrice ';
        $where = ' c.customer_id = ? AND c.delete_flg = ? ';
        $arrWhereVal = [$customer_id, 0];

        $res = $this->db->select($table, $column, $where, $arrWhereVal);
        return ($res !== false && count($res) !== 0) ? $res[0]['totalPrice'] : 0;
    }
}
