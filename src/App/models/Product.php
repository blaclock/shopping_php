<?php

namespace App\models;

use \HttpNotFoundException;

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
    // 商品リストを取得する

    public function getProductList()
    {
        // カテゴリーによって表示させるアイテムをかえる
        $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

        $table = ' products AS p INNER JOIN categories AS c ON p.category_id = c.id ';
        $col = 'p.id, p.name, p.image, p.price, c.name as category ';
        $where = ($category_id !== '') ? ' p.category_id = ? ' : '';
        $arrVal = ($category_id !== '') ? [$category_id] : [];

        // 商品数を取得
        $productNum = $this->db->count($table, $where, $arrVal);

        $this->db->setOrder('id DESC');
        // ページネーション
        $paginationInfo = $this->setPagination($productNum);
        // $paginationInfo['paginationUrl'] = '/products';
        // var_dump($_GET);
        // var_dump($paginationInfo);

        $res = $this->db->select($table, $col, $where, $arrVal);
        if ($res) {
            return [$res, $paginationInfo];
        }
        throw new HttpNotFoundException();
    }

    private function setPagination($productNum)
    {
        // $perPage = \App\consts\CommonConst::PAGINATION;
        $perPage = 4;
        // 商品数を１ページに表示する商品数で割った商を切り上げ
        $pageNum = (int)ceil($productNum / $perPage);
        $pageNum = ($pageNum === 0) ? 1 : $pageNum;

        if ($pageNum === 1) {
            return ['pageNum' => 1];
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $position = ($page > 1) ? ($page * $perPage) - $perPage : 0;
        $this->db->setLimitOff($perPage, $position);
        // var_dump($pageNum);

        return [
            'pageNum' => $pageNum,
            'productNum' => $productNum,
            'present' => $page,
            'url' => $this->setPaginationUrl()
        ];
    }

    private function setPaginationUrl()
    {
        $queries = isset($_GET) ? $_GET : [];
        $url = '/products?';

        foreach ($queries as $key => $query) {
            if ($key !== 'page') {
                $url .= $key . '=' . $query . '&';
            } else {
                $url .= 'page=';
            }
        }

        if (!array_key_exists('page', $queries)) {
            $url .= 'page=';
        }

        return $url;
    }

    // 商品の詳細情報を取得する
    public function getProductDetailData($product_id)
    {
        $table = ' products ';
        $col = ' id, name, detail, price, image, id ';

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
        $table = ' products AS p INNER JOIN categories AS c ON p.category_id = c.id ';
        $col = 'p.id, p.name, p.image, p.price, c.name ';

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
                    $where = " p.name = ? OR p.detail LIKE ? OR p.price = ? OR c.name = ? ";
                }

                $arrVal = [$word, '%' . $word . '%', $word, $word];
            }
        }

        // 商品数を取得
        $productNum = $this->db->count($table, $where, $arrVal);

        // ページネーション
        $paginationInfo = $this->setPagination($productNum);
        // $paginationInfo['paginationUrl'] = '/products/search';

        $this->db->setOrder('id DESC');
        // SELECT構文で検索
        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? [$res, $paginationInfo] : [[], $paginationInfo];
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
                $where .= ' (p.name = ? OR p.detail LIKE ? OR p.price = ? OR c.name = ?) ';
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
                $where .= ' (p.name = ? OR p.detail LIKE ? OR p.price = ? OR c.name = ?) ';
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
        $where = " NOT (p.name = ? OR p.detail LIKE ? OR p.price = ? OR c.name = ?) ";
        $word = mb_substr($word, 1); // １文字目の'-'を取り除く
        return [
            $where, $word
        ];
    }

    public function registerProduct()
    {
        $insData = [
            'name' => $_POST['name'],
            'detail' => $_POST['detail'],
            'price' => $_POST['price'],
            'image' => $_POST['image'],
            'category_id' => $_POST['category']
        ];

        $this->db->insert('products', $insData);
    }
}
