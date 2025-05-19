<?php

namespace App\models;

use App\core\CSV as CSV;

// メール関連
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Order extends Model
{
    private $order_id;

    public function addOrder($customer_id)
    {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $zip = $_POST['zip'];
        $delivery_to = $_POST['delivery_to'];
        $payment_type = $_POST['payment_type'];
        // 注文テーブルにレコードを挿入
        $table = ' orders ';
        $insData = [
            'customer_id' => $customer_id,
            'zip' => $zip,
            'delivery_to' => $delivery_to,
            'payment_type' => $payment_type,
        ];
        $this->db->insert($table, $insData);
        $this->order_id = $this->db->getLastId();

        // 注文明細テーブルにレコードを挿入
        $table = ' order_details ';
        foreach ($product_id as $key => $val) {
            $insData = [
                'order_id' => $this->order_id,
                'product_id' => $val,
                'quantity' => $quantity[$key]
            ];
            $this->db->insert($table, $insData);
        }
    }

    // カートの情報を取得する(必要な情報は、誰が$customer_id。必要な商品情報は名前、商品画像、金額)
    public function getOrderData($customer_id = '')
    {
        $table = ' orders AS o 
                    INNER JOIN order_details AS od 
                        ON o.id = od.order_id
                    INNER JOIN products AS p 
                        ON od.product_id = p.id 
                    INNER JOIN customers AS c 
                        ON o.customer_id = c.id ';
        $column = ' o.id, o.zip, o.delivery_to, o.payment_type, od.product_id, p.name, od.quantity, p.price, p.image, o.created_at, o.customer_id, c.family_name, c.first_name ';
        $where = ($customer_id !== '') ? ' o.customer_id = ? AND o.delete_flg = ? ' : '';
        $arrVal = ($customer_id !== '') ?  [$customer_id, 0] : [];

        // 絞り込み期間を設定
        $this->setOrderPeriod($where, $arrVal);
        // 商品数を取得
        $orderNum = $this->db->count($table, $where, $arrVal);

        $ordersAmount = $this->calcOrdersAmount($table, $column, $where, $arrVal);

        // ページネーション
        $paginationInfo = $this->setPagination($orderNum);

        $this->db->setOrder('id DESC');

        $res = $this->db->select($table, $column, $where, $arrVal);

        // return (count($res) !== 0) ? [$res, $orderNum, $paginationInfo, $ordersAmount] : [[],$orderNum,$paginationInfo,$ordersAmount];
        return [$res, $orderNum, $paginationInfo, $ordersAmount];
    }

    private function setOrderPeriod(&$where, &$arrVal)
    {
        if (!empty($_GET['period_beginning'])) {
            $where .= ' o.created_at >= ? ';
            if (!empty($_GET['period_ending'])) {
                $where .= 'AND';
            }
            $arrVal[] = $_GET['period_beginning'];
        }
        if (!empty($_GET['period_ending'])) {
            $where .= ' o.created_at <= ? ';
            $arrVal[] = $_GET['period_ending'] . ' 23:59:59';
        }
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

    private function calcOrdersAmount($table, $column, $where, $arrVal)
    {
        $orders = $this->db->select($table, $column, $where, $arrVal);

        $totalAmount = 0;
        if (count($orders) !== 0) {
            foreach ($orders as $order) {
                $totalAmount += $order['price'] * $order['quantity'];
            }
        }
        return $totalAmount;
    }

    public function exportCSV()
    {
        $table = ' orders AS o 
                    INNER JOIN order_details AS od 
                        ON o.id = od.order_id
                    INNER JOIN products AS p 
                        ON od.product_id = p.id 
                    INNER JOIN customers AS c 
                        ON o.customer_id = c.id ';
        $col = ' o.id, od.id as detail_id, od.product_id, p.name, p.price, od.quantity, p.price * od.quantity, o.customer_id, c.family_name, c.first_name, o.zip, o.delivery_to, o.payment_type, o.created_at ';
        $where = '';
        $arrVal = [];
        $this->setOrderPeriod($where, $arrVal);

        // SELECT構文で検索
        $res = $this->db->select($table, $col, $where, $arrVal);
        if ($res === false) {
            echo 'ファイルのエクスポートに失敗しました<br>';
        } else {
            $list = [
                [
                    '注文ID',
                    '注文明細ID',
                    '商品ID',
                    '商品名',
                    '単価',
                    '数量',
                    '金額',
                    '発注者ID',
                    '発注者(氏)',
                    '発注者(名)',
                    '郵便番号',
                    '配達先',
                    '支払い方法',
                    '発注日'
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

    //     public function informOrders($customer)
    //     {
    //         $product_id = $_POST['product_id'];
    //         $quantity = $_POST['quantity'];
    //         $zip = $_POST['zip'];
    //         $delivery_to = $_POST['delivery_to'];
    //         $payment_type = $_POST['payment_type'];

    //         $mail = new PHPMailer(true);
    //         $email = $customer['email'];
    //         $contents = '';
    //         foreach($product_id as $key => $val){
    //             $contents = ""
    //         }

    //         try {
    //             //Gmail 認証情報
    //             $host = 'smtp.gmail.com';
    //             $username = 'blaclock@gmail.com'; // example@gmail.com
    //             $password = 'dfzynjllhobfuudc';

    //             //差出人
    //             $from = 'blaclock@gmail.com';
    //             $fromName = '黒岩知宏';

    //             //宛先
    //             $to = $email;
    //             $toName = '宛名';

    //             //件名・本文
    //             $subject = '購入商品のお知らせ';
    //             $body = <<<EOM
    // 商品をご購入いただきありがとうございます。
    // 以下となります。

    // EOM;

    //             //メール設定
    //             $mail->SMTPDebug = 2; //デバッグ用
    //             $mail->isSMTP();
    //             $mail->SMTPAuth = true;
    //             $mail->Host = $host;
    //             $mail->Username = $username;
    //             $mail->Password = $password;
    //             $mail->SMTPSecure = 'tls';
    //             $mail->Port = 587;
    //             $mail->CharSet = "utf-8";
    //             $mail->Encoding = "base64";
    //             $mail->setFrom($from, $fromName);
    //             $mail->addAddress($to, $toName);
    //             $mail->Subject = $subject;
    //             $mail->Body    = $body;

    //             //メール送信
    //             $mail->send();

    //             header('Location: ' . '/login');
    //         } catch (Exception $e) {
    //             echo '失敗: ', $mail->ErrorInfo;
    //         }

    //         // 注文明細テーブルにレコードを挿入
    //         $table = ' order_details ';
    //         foreach ($product_id as $key => $val) {
    //             $insData = [
    //                 'order_id' => $this->order_id,
    //                 'product_id' => $val,
    //                 'quantity' => $quantity[$key]
    //             ];
    //             $this->db->insert($table, $insData);
    //         }
    //     }
}
