<?php

namespace App\models;

use \HttpNotFoundException;

class Customer extends Model
{
    public function registerCustomer()
    {
        $insData = [
            'family_name' => $_POST['family_name'],
            'first_name' => $_POST['first_name'],
            'family_name_kana' => $_POST['family_name_kana'],
            'first_name_kana' => $_POST['first_name_kana'],
            'first_name_kana' => $_POST['first_name_kana'],
            'account_name' => $_POST['account_name'],
            'sex' => $_POST['sex'],
            'birth' => $_POST['birth'],
            'email' => $_POST['email'],
            'tel' => $_POST['tel'],
            'zip' => $_POST['zip'],
            'address' => $_POST['address'],
            'password' => $_POST['password']
        ];

        $res = $this->db->insert('customers', $insData);
    }

    public function getCustomer($customer_id)
    {
        $table = ' customers ';
        $col = ' * ';

        $where = ($customer_id !== '') ? ' id = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($customer_id !== '') ? [$customer_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? $res[0] : false;
    }

    public function updateCustomer($customer_id)
    {
        $table = ' customers ';

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
        $arrVal = [$customer_id];

        $res = $this->db->update($table, $insData, $where, $arrVal);
    }

    public function deleteCustomer($customer_id)
    {
        $table = ' customers ';
        $where = ' id = ? ';
        $res = $this->db->delete($table, $where, [$customer_id]);
        if ($res !== false) {
            unset($_SESSION['customer']);
        }
    }

    public function confirmPassword($email)
    {
        $table = ' customers ';
        $col = ' password ';

        $where = ($email !== '') ? ' email = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($email !== '') ? [$email] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? $res[0]['password'] : false;
    }
}
