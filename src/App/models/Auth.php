<?php

namespace App\models;

class Auth extends Model
{

    public function login()
    {
        $table = ' customers ';
        $col = ' * ';

        $where = ' email = ? AND password = ? ';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = [$_POST['email'], $_POST['password']];

        $res = $this->db->select($table, $col, $where, $arrVal);

        if (count($res) !== 0) {
            //session_start();
            $_SESSION['customer'] = $res[0];
            return $res;
        } else {
            return false;
        }
    }

    public static function logout()
    {
        //session_start();
        unset($_SESSION['customer']);
        header('Location: /');
    }

    public static function check()
    {
        //session_start();
        return (isset($_SESSION['customer'])) ? true : false;
    }
}
