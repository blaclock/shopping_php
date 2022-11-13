<?php

class ProductController extends Controller
{
    public function run($action)
    {
        $this->$action();
    }

    public function index()
    {
        echo 'ProductController<br>';
        // include $_ENV['TMP_DIR'] . 'list.php';
        // include './../../resources/views/list.php';
        // include 'test.php'; 開けた
        include '../resources/views/test.php';
        // include '/Users/kuroiwatomohiro/Documents/code/shopping/src/resources/views/test.php';
        // include $_ENV['TMP_DIR'] . 'test.php';
    }

    public function list()
    {
        $db = new PDODatabase(
            $_ENV['DB_HOST'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS'],
            $_ENV['DB_NAME'],
            $_ENV['DB_TYPE']
        );
        // $ses = new Session($db);
        $itm = new Item($db);

        // SessionKeyを見て、DBへの登録状態をチェックする
        // $ses->checkSession();
        $ctg_id =
            (isset($_GET['ctg_id']) === true && preg_match('/^[0-9]+$/', $_GET['ctg_id']) === 1)
            ? $_GET['ctg_id']
            : '';

        // カテゴリーリスト(一覧)を取得する
        $cateArr = $itm->getCategoryList();

        // 商品リストを取得する
        if (isset($_POST['send'])) {
            $dataArr = $itm->searchWord($_POST['search']);
        } else {
            $dataArr = $itm->getItemList($ctg_id);
        }

        $this->view('product.product', [
            "variable1" => "Hello",
            "variable2" => "World"
        ]);
    }
}
