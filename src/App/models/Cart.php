<?php

namespace App\models;

class Cart extends Model
{
    // カートに登録する(必要な情報は、誰が$customer_id、何を($item_id))
    public function addCart($customer_id, $product_id, $quantity)
    {
        $table = ' carts ';
        $insData = [
            'customer_id' => $customer_id,
            'product_id' => $product_id,
            'quantity' => $quantity
        ];
        return $this->db->insert($table, $insData);
    }

    // カートの情報を取得する(必要な情報は、誰が$customer_id。必要な商品情報は名前、商品画像、金額)
    public function getCartData($customer_id)
    {
        $table = ' carts AS c INNER JOIN products AS p ON c.product_id = p.id ';
        $column = ' c.id, c.product_id, p.name, c.quantity, p.price, p.image ';
        $where = ' c.customer_id = ? AND c.delete_flg = ? ';
        $arrVal = [$customer_id, 0];

        $res = $this->db->select($table, $column, $where, $arrVal);
        return (count($res) !== 0) ? $res : false;
    }

    public function updateCart()
    {
        $cart_id = $_GET['cart_id'];
        $quantity = $_GET['quantity'];
        $table = ' carts ';
        $insData = ['quantity' => $quantity];
        $where = ' id = ? ';
        $arrWhereVal = [$cart_id];

        return $this->db->update($table, $insData, $where, $arrWhereVal);
    }

    // カート情報を削除する：必要な情報はどのカートを($crt_id)
    public function deleteCart($cart_id)
    {
        $table = ' carts ';
        $insData = ['delete_flg' => 1];
        $where = ' id = ? ';
        $arrWhereVal = [$cart_id];

        return $this->db->update($table, $insData, $where, $arrWhereVal);
    }

    public function orderedCart($cart_id)
    {
        $table = ' carts ';
        $where = ' id = ? ';
        foreach ($cart_id as $id) {
            $arrWhereVal = [$id];
            $insData = ['delete_flg' => 1];
            $this->db->update($table, $insData, $where, $arrWhereVal);
        }
    }

    // アイテム数と合計金額を取得する
    public function getTotalQuantity($customer_id)
    {
        $table = ' carts ';
        $column = ' SUM( quantity ) AS total_quantity ';
        $where = ' customer_id = ? AND delete_flg = ? ';
        $arrWhereVal = [$customer_id, 0];
        $res = $this->db->select($table, $column, $where, $arrWhereVal);

        return ($res !== false && count($res) !== 0) ? $res[0]['total_quantity'] : 0;
    }

    // アイテム数と合計金額を取得する
    public function getTotalAmount($customer_id)
    {
        $table = ' carts c INNER JOIN products p ON c.product_id = p.id ';
        $column = ' SUM( p.price * c.quantity ) AS totalPrice ';
        $where = ' c.customer_id = ? AND c.delete_flg = ? ';
        $arrWhereVal = [$customer_id, 0];

        $res = $this->db->select($table, $column, $where, $arrWhereVal);
        return ($res !== false && count($res) !== 0) ? $res[0]['totalPrice'] : 0;
    }
}
