<?php
/*
 * ファイルパス：/Applications/MAMP/htdocs/DT/shopping\lib\Item.class.php
 * ファイル名：Item.class.php (商品に関するプログラムのクラスファイル、Model)
 */

class Item
{
    public $cateArr = [];
    public $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }
    // カテゴリーリストの取得

    public function getCategoryList()
    {
        $table = ' category ';
        $col = ' ctg_id, category_name ';
        $res = $this->db->select($table, $col);
        return $res;
    }
    // 商品リストを取得する

    public function getItemList($ctg_id)
    {
        // カテゴリーによって表示させるアイテムをかえる
        $table = ' item ';
        $col = ' item_id, item_name, price,image, ctg_id ';
        $where = ($ctg_id !== '') ? ' ctg_id = ? ' : '';
        $arrVal = ($ctg_id !== '') ? [$ctg_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);

        return ($res !== false && count($res) !== 0) ? $res : false;
    }
    // 商品の詳細情報を取得する

    public function getItemDetailData($item_id)
    {
        $table = ' item ';
        $col = ' item_id, item_name, detail, price, image, ctg_id ';

        $where = ($item_id !== '') ? ' item_id = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($item_id !== '') ? [$item_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);

        return ($res !== false && count($res) !== 0) ? $res : false;
    }

    public function getPriceItemList($price)
    {
        $table = ' item ';
        $col = ' item_id, item_name, detail, price, image, ctg_id ';

        $where = ($price !== '') ? ' price = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($price !== '') ? [$price] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);

        return ($res !== false && count($res) !== 0) ? $res : false;
    }

    public function searchWord($word)
    {

        $table = ' item AS i INNER JOIN category AS c ON i.ctg_id = c.ctg_id ';
        $col = 'i.item_id, i.item_name, i.image, i.price, c.category_name ';

        // AND検索に対応
        if (strpos($word, '　') || strpos($word, ' ')) {
            // 半角スペース、全角スペースに対応
            // 連続したスーペースには対応していない
            $word = str_replace(['　', ' '], [',', ','], $word);
            $words = explode(',', $word);
            $where = '';
            $arrVal = [];
            for ($i = 0; $i < count($words); $i++) {
                $where .= ' (i.item_name = ? OR i.detail LIKE ? OR i.price = ? OR c.category_name = ?) ';
                if ($i <= count($words) - 2) {
                    $where .= 'AND';
                }
                $arrVal = array_merge($arrVal, [$words[$i], '%' . $words[$i] . '%', $words[$i], $words[$i]]);
            }
        } else {
            $where = " i.item_name = ? OR i.detail LIKE ? OR i.price = ? OR c.category_name = ? ";
            $arrVal = [$word, '%' . $word . '%', $word, $word];
        }

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? $res : false;
    }

    public function registerItem()
    {
        $insData = [
            'item_name' => $_POST['item_name'],
            'detail' => $_POST['item_detail'],
            'price' => $_POST['item_price'],
            'image' => $_POST['item_image'],
            'ctg_id' => $_POST['item_category']
        ];

        $this->db->insert('item', $insData);
    }
}
