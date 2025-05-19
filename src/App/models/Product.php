<?php

namespace App\models;

use \HttpNotFoundException;
use App\core\CSV as CSV;

class Product extends Model
{
    // カテゴリーリストの取得
    public function getCategoryList()
    {
        $table = ' categories ';
        $col = ' id, name ';
        $res = $this->db->select($table, $col);
        return $res;
    }

    public function getTop5()
    {
        $table = <<<EOM
(
SELECT t1.id,
t1.name,
t1.image,
t1.price,
t1.category_id,
t1.category,
t1.detail,
t1.created_at,
t1.updated_at,
t1.score,
t1.reviews,
t1.delete_flag,
count(pf.product_id) AS likes
from (
SELECT p.id,
p.name,
p.image,
p.price,
p.detail,
p.category_id,
p.created_at,
p.updated_at,
p.delete_flag,
c.name AS category,
avg(r.score) AS score,
count(r.product_id) AS reviews
FROM products AS p
INNER JOIN categories AS c ON p.category_id = c.id
LEFT OUTER JOIN reviews AS r ON p.id = r.product_id
GROUP BY p.id
) AS t1
LEFT OUTER JOIN product_favorites AS pf on t1.id = pf.product_id
GROUP BY t1.id
) AS t2
EOM;
        $col = ' t2.id,t2.name,t2.image,t2.price,t2.category_id,t2.category,t2.created_at,t2.updated_at,t2.score,t2.reviews,t2.likes ';
        $where = ' t2.delete_flag = ? ';
        $arrVal = [0];
        $this->db->setOrder(' t2.likes DESC ');
        $this->db->setLimitOff(5);
        $res = $this->db->select($table, $col, $where, $arrVal);
        return ($res) ? $res : false;
    }
    // 商品リストを取得する
    public function getProductList()
    {
        // カテゴリーによって表示させるアイテムをかえる
        $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

        // 商品数をカウントしてページネーションの情報を取得するためのクエリの準備
        $table = <<<EOM
(
SELECT t1.id,
t1.name,
t1.image,
t1.price,
t1.category_id,
t1.category,
t1.detail,
t1.created_at,
t1.updated_at,
t1.score,
t1.reviews,
t1.delete_flag,
count(pf.product_id) AS likes
from (
SELECT p.id,
p.name,
p.image,
p.price,
p.detail,
p.category_id,
p.created_at,
p.updated_at,
p.delete_flag,
c.name AS category,
avg(r.score) AS score,
count(r.product_id) AS reviews
FROM products AS p
INNER JOIN categories AS c ON p.category_id = c.id
LEFT OUTER JOIN reviews AS r ON p.id = r.product_id
GROUP BY p.id
) AS t1
LEFT OUTER JOIN product_favorites AS pf on t1.id = pf.product_id
GROUP BY t1.id
) AS t2
EOM;
        $col = ' t2.id,t2.name,t2.image,t2.price,t2.category_id,t2.category,t2.created_at,t2.updated_at,t2.score,t2.reviews,t2.likes ';
        $where = ($category_id !== '') ? ' t2.category_id = ? AND t2.delete_flag = ? ' : ' t2.delete_flag = ? ';
        $arrVal = ($category_id !== '') ? [$category_id, 0] : [0];
        $this->setFilterCondition($where, $arrVal, 't2');
        // 商品数を取得
        $productNum = $this->db->count($table, $where, $arrVal);
        // var_dump($productNum);
        // ページネーション
        $paginationInfo = $this->setPagination($productNum);

        // 検索結果の抽出順を指定
        $this->db->setOrder($this->setSortCondition('t2'));
        // $this->db->setGroupBy('t1.id');

        $res = $this->db->select($table, $col, $where, $arrVal);

        if ($res) {
            return [$res, $productNum, $paginationInfo];
        } else {
            return [[], $productNum, $paginationInfo];
        }
    }

    private function setFilterCondition(&$where, &$arrVal, $table = 't1')
    {
        if ($where !== '') {
            $where .= 'AND';
        }

        foreach ($_GET as $column => $param) {
            if (!empty($param)) {
                switch ($column) {
                    case 'price_low':
                        $where .=  ' ' . $table . '.price >= ? AND';
                        $arrVal[] = $param;
                        break;
                    case 'price_high':
                        $where .=  ' ' . $table . '.price <= ? AND';
                        $arrVal[] = $param;
                        break;
                    case 'score_filter':
                        $where .=  ' ' . $table . '.score >= ? AND';
                        $arrVal[] = $param;
                        break;
                    case 'category_filter':
                        $where .=  ' ' . $table . '.category = ? AND';
                        $arrVal[] = $param;
                        break;
                    default:
                        break;
                }
            }
        }

        if ($where !== '') {
            $where = substr($where, 0, -3);
        }
    }

    private function setSortCondition($table = 't1')
    {
        if (isset($_GET['sort'])) {
            $sort = explode('_', $_GET['sort']);
            if ($sort[1] === 'at') {
                return $sort[0] . '_' . $sort[1] . ' ' . $sort[2] . ',' . $table . '.id DESC';
            } else {
                return $sort[0] . ' ' . $sort[1] . ',' . $table . '.id DESC';
            }
        } else {
            return $table . '.id DESC';
        }
    }

    // 商品の詳細情報を取得する
    public function getProductDetailData($product_id)
    {
        $table = ' products ';
        $col = ' id, name, detail, price, image, category_id ';

        $where = ($product_id !== '') ? ' id = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($product_id !== '') ? [$product_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);
        if ($res) {
            return $res[0];
        }
        throw new HttpNotFoundException();
    }


    public function searchProduct($word)
    {
        $table = <<<EOM
(
SELECT t1.id,
t1.name,
t1.image,
t1.price,
t1.category_id,
t1.category,
t1.detail,
t1.created_at,
t1.updated_at,
t1.score,
t1.reviews,
t1.delete_flag,
count(pf.product_id) AS likes
from (
SELECT p.id,
p.name,
p.image,
p.price,
p.detail,
p.category_id,
p.created_at,
p.updated_at,
p.delete_flag,
c.name AS category,
avg(r.score) AS score,
count(r.product_id) AS reviews
FROM products AS p
INNER JOIN categories AS c ON p.category_id = c.id
LEFT OUTER JOIN reviews AS r ON p.id = r.product_id
GROUP BY p.id
) AS t1
LEFT OUTER JOIN product_favorites AS pf on t1.id = pf.product_id
GROUP BY t1.id
) AS t2
EOM;
        $col = ' t2.id,t2.name,t2.image,t2.price,t2.category_id,t2.category,t2.created_at,t2.updated_at,t2.score,t2.reviews,t2.likes ';

        // 半角スペース、もしくは全角スペースがあったら複数単語検索(AND検索)
        if (strpos($word, '　') || strpos($word, ' ')) {
            list($where, $arrVal) = $this->andSearch($word);
        } else { //単数単語検索(AND検索ではない)
            // OR検索の場合
            if (strpos($word, '|')) {
                list($where, $arrVal) = $this->orSearch($word);
            } else {
                // 検索ワードの１文字目に'-'が含まれていたらNOT検索
                if (mb_substr($word, 0, 1) === '-') {
                    list($where, $word) = $this->notSearch($word);
                } else {
                    $where = " (t2.name = ? OR t2.detail LIKE ? OR t2.price = ? OR t2.category = ?) ";
                }

                $arrVal = [$word, '%' . $word . '%', $word, $word];
            }
        }
        $this->setFilterCondition($where, $arrVal, 't2');
        $where .= ' AND t2.delete_flag = ? ';
        $arrVal[] = 0;

        // 商品数を取得
        $productNum = $this->db->count($table, $where, $arrVal);
        // ページネーション
        $paginationInfo = $this->setPagination($productNum);

        // 検索結果の抽出順を指定
        $this->db->setOrder($this->setSortCondition('t2'));

        // SELECT構文で検索
        $res = $this->db->select($table, $col, $where, $arrVal);

        return (count($res) !== 0) ? [$res, $productNum, $paginationInfo] : [[], 0, $paginationInfo];
    }

    public function andSearch(string $word)
    {
        // 半角スペース、全角スペースを','に置き換えて、explodeで
        $words = str_replace(['　', ' '], [',', ','], $word);
        $words = explode(',', $words);
        $where = '';
        $arrVal = [];
        for ($i = 0; $i < count($words); $i++) {
            // 検索ワードの１文字目に'-'が含まれていたらNOT検索
            if (mb_substr($words[$i], 0, 1) === '-') {
                list($whereSql, $words[$i]) = $this->notSearch($words[$i]);
                $where .= $whereSql;
            } else {
                $where .= ' (t2.name = ? OR t2.detail LIKE ? OR t2.price = ? OR t2.category = ?) ';
            }

            if ($i < count($words) - 1) {
                $where .= 'AND';
            }
            //検索ワードが商品名、詳細、価格、カテゴリ名に含まれるかの条件設定
            $arrVal = array_merge($arrVal, [$words[$i], '%' . $words[$i] . '%', $words[$i], $words[$i]]);
        }
        return [
            $where, $arrVal
        ];
    }

    public function orSearch(string $words)
    {
        $where = '';
        $arrVal = [];
        $words = explode('|', $words);
        for ($i = 0; $i < count($words); $i++) {
            // 検索ワードの１文字目に'-'が含まれていたらNOT検索
            if (mb_substr($words[$i], 0, 1) === '-') {
                list($whereSql, $words[$i]) = $this->notSearch($words[$i]);
                $where .= $whereSql;
            } else {
                $where .= ' (t2.name = ? OR t2.detail LIKE ? OR t2.price = ? OR t2.category = ?) ';
            }

            if ($i < count($words) - 1) {
                $where .= 'OR';
            }
            $arrVal = array_merge($arrVal, [$words[$i], '%' . $words[$i] . '%', $words[$i], $words[$i]]);
        }
        return [
            $where, $arrVal
        ];
    }

    public function notSearch($word)
    {
        $where = " NOT (t2.name = ? OR t2.detail LIKE ? OR t2.price = ? OR t2.category = ?) ";
        $word = mb_substr($word, 1); // １文字目の'-'を取り除く
        return [
            $where, $word
        ];
    }

    public function registerProduct()
    {
        $insData = [
            'name' => $_POST['name'],
            'detail' => htmlspecialchars($_POST['detail'], ENT_QUOTES, 'UTF-8'),
            'price' => $_POST['price'],
            'image' => $_POST['image'],
            'category_id' => $_POST['category']
        ];

        $this->db->insert('products', $insData);
    }

    public function updateProduct($product_id)
    {
        $table = ' products ';

        // 更新時間を取得
        $update_time = date('Y-m-d H:i:s');

        $insData = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'category_id' => $_POST['category_id'],
            'detail' => htmlspecialchars($_POST['detail'], ENT_QUOTES, 'UTF-8'),
            'updated_at' => $update_time
        ];

        if ($_POST['image'] !== '') {
            $insData['image'] = $_POST['image'];
        }

        $where = ' id = ? ';
        $arrVal = [$product_id];

        $res = $this->db->update($table, $insData, $where, $arrVal);
    }

    public function deleteProduct($product_id)
    {
        $table = ' products ';
        // 削除時間を取得
        $deleted_time = date('Y-m-d H:i:s');
        $insData = [
            'delete_flag' => 1,
            'deleted_at' => $deleted_time
        ];
        $where = ' id = ? ';
        $arrVal = [$product_id];
        $res = $this->db->update($table, $insData, $where, $arrVal);

        // 画像の削除
        // $product = $this->getProductDetailData($product_id);
        // if ($res !== false) {
        //     unlink(\App\consts\CommonConst::IMG_DIR . 'products/' . $product['image']);
        // }
    }

    public function exportCSV()
    {
        $table = <<<EOM
(
SELECT t1.id,
t1.name,
t1.image,
t1.price,
t1.category_id,
t1.category,
t1.detail,
t1.created_at,
t1.updated_at,
t1.score,
t1.reviews,
count(pf.product_id) AS likes
from (
SELECT p.id,
p.name,
p.image,
p.price,
p.detail,
p.category_id,
p.created_at,
p.updated_at,
c.name AS category,
avg(r.score) AS score,
count(r.product_id) AS reviews
FROM products AS p
INNER JOIN categories AS c ON p.category_id = c.id
LEFT OUTER JOIN reviews AS r ON p.id = r.product_id
GROUP BY p.id
) AS t1
LEFT OUTER JOIN product_favorites AS pf on t1.id = pf.product_id
GROUP BY t1.id
) AS t2
EOM;
        $col = ' t2.id,t2.name,t2.image,t2.price,t2.category_id,t2.category,t2.detail,t2.created_at,t2.updated_at,t2.score,t2.reviews,t2.likes ';

        // SELECT構文で検索
        $res = $this->db->select($table, $col);
        if ($res === false) {
            echo 'ファイルのエクスポートに失敗しました<br>';
        } else {
            $list = [
                [
                    'id',
                    '商品名',
                    '画像',
                    '価格',
                    'カテゴリーID',
                    'カテゴリー名',
                    '商品詳細',
                    '登録日',
                    '更新日',
                    '評価',
                    'レビュー数',
                    'いいね数'
                ]
            ];
            foreach ($res as $rec) {
                $data = [];
                foreach ($rec as $val) {
                    $data[] = $val;
                }
                // var_dump($data);
                $list[] = $data;
            }
            CSV::export($list);
        }
    }
}
