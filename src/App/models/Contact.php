<?php

namespace App\models;

use \HttpNotFoundException;

class Contact extends Model
{
    public function getContacts($customer_id = '')
    {
        $table = ' contacts AS con
                    INNER JOIN customers AS cus
                        ON con.customer_id = cus.id ';

        $col = ' cus.id as customer_id, cus.account_name, con.id as contact_id, con.sender, con.message, con.created_at ';

        $where = ($customer_id !== '') ? ' con.customer_id = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($customer_id !== '') ? [$customer_id] : [];

        $this->db->setOrder('created_at ASC');

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? $res : [];
    }

    public function sendMessage($customer_id, $sender)
    {
        $insData = [
            'customer_id' => $customer_id,
            'admin_id' => 1,
            'sender' => $sender,
            'message' => $_POST['message']
        ];

        $res = $this->db->insert('contacts', $insData);
    }

    public function getCustomers($messages)
    {
        if (count($messages) === 0) {
            return [];
        }

        $messages = array_reverse($messages);
        $contacts = [];
        foreach ($messages as $message) {
            $customer_id = $message['customer_id'];
            if (!array_key_exists($customer_id, $contacts)) {
                $contacts[$customer_id]['customer_id'] = $message['customer_id'];
                $contacts[$customer_id]['account_name'] = $message['account_name'];
                $contacts[$customer_id]['message'] = $message['message'];
                $contacts[$customer_id]['created_at'] = $message['created_at'];
            }
        }

        return $contacts;
    }

    public function deleteContact($contact_id)
    {
        // 削除時間を取得
        $deleted_time = date('Y-m-d H:i:s');

        $table = ' contacts ';
        $insData = [
            'deleted_at' => $deleted_time,
            'delete_flag' => 1
        ];
        $where = ' id = ? ';
        $arrVal = [$contact_id];
        $this->db->update($table, $insData, $where, $arrVal);
    }
}
