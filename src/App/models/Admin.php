<?php

namespace App\models;

use \HttpNotFoundException;

class Admin extends Model
{
    public function registerAdmin()
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

        $res = $this->db->insert('admins', $insData);
    }

    public function getAdmins()
    {
        $table = ' admins ';
        $col = ' * ';
        $where = ' delete_flag = ? ';
        $arrVal = [0];

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? $res : false;
    }

    public function getAdmin($admin_id)
    {
        $table = ' admins ';
        $col = ' * ';

        $where = ($admin_id !== '') ? ' id = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($admin_id !== '') ? [$admin_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? $res[0] : false;
    }

    public function updateAdmin($admin_id)
    {
        $table = ' admins ';

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
        $arrVal = [$admin_id];

        $this->db->update($table, $insData, $where, $arrVal);
    }

    public function deleteAdmin($admin_id)
    {
        // 削除時間を取得
        $deleted_time = date('Y-m-d H:i:s');

        $table = ' admins ';
        $insData = [
            'deleted_at' => $deleted_time,
            'delete_flag' => 1
        ];
        $where = ' id = ? ';
        $arrVal = [$admin_id];
        // $res = $this->db->delete($table, $where, [$admin_id]);
        $res = $this->db->update($table, $insData, $where, $arrVal);
        if ($res !== false) {
            unset($_SESSION['admin']);
        }
    }

    public function confirmPassword($email)
    {
        $table = ' admins ';
        $col = ' password ';

        $where = ($email !== '') ? ' email = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($email !== '') ? [$email] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? $res[0]['password'] : false;
    }

    public function registerAdminCSV()
    {
        # code...
    }
}
