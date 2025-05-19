<?php

namespace App\models;

use \HttpNotFoundException;
use App\core\CSV as CSV;

class Customer extends Model
{
    public function registerCustomer()
    {
        $insData = [
            'family_name' => $_POST['family_name'],
            'first_name' => $_POST['first_name'],
            'family_name_kana' => $_POST['family_name_kana'],
            'first_name_kana' => $_POST['first_name_kana'],
            'account_name' => $_POST['account_name'],
            'sex' => $_POST['sex'],
            'birth' => $_POST['birth'],
            'email' => $_POST['email'],
            'tel' => $_POST['tel'],
            'zip' => $_POST['zip'],
            'address' => $_POST['address'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];

        $res = $this->db->insert('customers', $insData);
    }

    public function getCustomers()
    {
        $table = ' customers ';
        $col = ' * ';
        $where = ' delete_flag = ? ';
        $arrVal = [0];

        // 商品数を取得
        $customerNum = $this->db->count($table, $where, $arrVal);

        // ページネーション
        $paginationInfo = $this->setPagination($customerNum);

        // ソート順を指定
        $this->db->setOrder('id DESC');

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? [$res, $customerNum, $paginationInfo] : false;
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

        $this->db->update($table, $insData, $where, $arrVal);
    }

    public function deleteCustomer($customer_id)
    {
        // 削除時間を取得
        $deleted_time = date('Y-m-d H:i:s');

        $table = ' customers ';
        $insData = [
            'deleted_at' => $deleted_time,
            'delete_flag' => 1
        ];
        $where = ' id = ? ';
        $arrVal = [$customer_id];
        // $res = $this->db->delete($table, $where, [$customer_id]);
        $res = $this->db->update($table, $insData, $where, $arrVal);
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

    public function registerCustomerCSV()
    {
        # code...
    }

    public function searchPostCode()
    {
        $zip = str_replace('-', '', $_GET['zip']);
        $table = ' postcodes ';
        $col = ' pref,city,town ';

        $where = ($zip !== '') ? ' zip = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($zip !== '') ? [$zip] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);
        echo ($res !== '' && count($res) !== 0) ? $res[0]['pref'] . $res[0]['city'] . $res[0]['town'] : '';
    }

    public function exportCSV()
    {
        $table = ' customers ';
        $col = ' id, family_name, first_name, family_name_kana, first_name_kana, account_name, sex, birth, zip, email, tel, created_at, updated_at ';
        $where = ' delete_flag = ? ';
        $arrVal = [0];

        // SELECT構文で検索
        $res = $this->db->select($table, $col, $where, $arrVal);
        if ($res === false) {
            echo 'ファイルのエクスポートに失敗しました<br>';
        } else {
            $list = [
                [
                    '顧客ID',
                    '氏',
                    '名',
                    '氏(カナ)',
                    '名(カナ)',
                    'アカウント名',
                    '性別',
                    '生年月日',
                    '郵便番号',
                    '住所',
                    'メールアドレス',
                    '電話番号',
                    '登録日',
                    '更新日'
                ]
            ];
            foreach ($res as $rec) {
                $data = [];
                foreach ($rec as $val) {
                    $data[] = $val;
                }
                // var_dump($rec);
                $list[] = $data;
            }
            CSV::export($list);
        }
    }
}
