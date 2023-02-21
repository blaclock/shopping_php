<?php

namespace App\models;

class Auth extends Model
{

    public function login()
    {
        $table = ' customers ';
        $col = ' * ';

        $where = ' email = ? AND password = ? AND delete_flag = ? ';
        $arrVal = [$_POST['email'], $_POST['password'], 0];

        $res = $this->db->select($table, $col, $where, $arrVal);

        if (count($res) !== 0) {
            $_SESSION['customer'] = $res[0];
            return $res;
        } else {
            return false;
        }
    }

    public function loginAdmin()
    {
        $table = ' admins ';
        $col = ' * ';

        $where = ' email = ? AND password = ? ';
        $arrVal = [$_POST['email'], $_POST['password']];

        $res = $this->db->select($table, $col, $where, $arrVal);

        if (count($res) !== 0) {
            $_SESSION['admin'] = $res[0];
            return $res;
        } else {
            return false;
        }
    }

    public static function logout()
    {
        unset($_SESSION['customer']);
        header('Location: /');
    }

    public static function logoutAdmin()
    {
        unset($_SESSION['admin']);
        header('Location: /');
    }

    public static function check()
    {
        return (isset($_SESSION['customer'])) ? true : false;
    }

    public static function checkAdmin()
    {
        return (isset($_SESSION['admin'])) ? true : false;
    }
}
