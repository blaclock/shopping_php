<?php

class Application
{
    protected $request;
    protected $router;
    protected $response;
    protected $model;

    public function __construct()
    {
        // phpinfo();
        $this->router = new Router($this->registerRoutes());
        $this->request = new Request();
        $this->response = new Response();
        $this->model = new \App\models\Model();
    }

    public function run()
    {
        try {
            $params = $this->router->resolve($this->request->getPathInfo());
            // アクセスされたURLがルーティングに登録されていなかったら例外を投げる
            if (!$params) {
                throw new HttpNotFoundException();
            }
            $controller = $params['controller'];
            $action = $params['action'];
            $this->runAction($controller, $action);
        } catch (HttpNotFoundException) { // 投げられた例外をキャッチして404ページを表示する
            $this->response->setStatusCode(404, 'Not Found');
            $this->response->send();
            $this->render404Page();
        }
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getModel()
    {
        return $this->model;
    }

    private function runAction($controllerName, $action)
    {
        // var_dump($controllerName);
        // namespaceで名前空間を定義しているので、コントローラーで定義されている名前空間を結合する
        $controllerClass = 'App\\controllers\\' . ucfirst($controllerName) . 'Controller';
        // var_dump($controllerClass);
        // コントローラーがない場合に例外を投げる
        if (!class_exists($controllerClass)) {
            throw new HttpNotFoundException();
        }
        // var_dump($controllerClass);
        $controller = new $controllerClass($this);
        $controller->run($action);
    }

    private function registerRoutes()
    {
        // ルーティングのパターンを登録
        return [
            '/' => ['controller' => 'Product', 'action' => 'index'],
            // 商品表示
            '/products\?q=[0-9０-９a-zA-Zぁ-んーァ-ヶー一-龠\-\|\s]*[\&page=\d+]*' => ['controller' => 'Product', 'action' => 'search'],
            '/products[\?category_id=\d+]*[\&*\?*period_beginning=[0-9\-]*]*[\&*\?*period_ending=[0-9\-]*]*[\&sort=[a-zA-Z\_]*]*[\&page=\d+]*' => ['controller' => 'Product', 'action' => 'index'],
            '/product\?id=\d+' => ['controller' => 'Product', 'action' => 'show'],
            // レビュー
            '/product/review\?product_id=\d+' => ['controller' => 'Review', 'action' => 'create'],
            '/product/review/store' => ['controller' => 'Review', 'action' => 'store'],
            // カート
            '/cart' => ['controller' => 'Cart', 'action' => 'index'],
            '/cart/add' => ['controller' => 'Cart', 'action' => 'store'],
            '/cart/update\?cart_id=\d+\&quantity=\d+' => ['controller' => 'Cart', 'action' => 'update'],
            '/cart/delete\?cart_id=\d+' => ['controller' => 'Cart', 'action' => 'destroy'],
            // '/cart/add\?token=[0-9a-z.]+[\&product_id=\d+]+[\?quantity=\d+]+' => ['controller' => 'Cart', 'action' => 'store'],
            // ログイン
            '/login' => ['controller' => 'Login', 'action' => 'index'],
            '/login/confirm' => ['controller' => 'Login', 'action' => 'confirm'],
            '/logout' => ['controller' => 'Login', 'action' => 'logout'],
            // パスワード再設定
            '/password/confirm' => ['controller' => 'Login', 'action' => 'confirmPassword'],
            '/password/send' => ['controller' => 'Login', 'action' => 'sendPassword'],
            // マイページ
            '/mypage' => ['controller' => 'Customer', 'action' => 'top'],
            '/register' => ['controller' => 'Customer', 'action' => 'create'],
            '/register/confirm' => ['controller' => 'Customer', 'action' => 'store'],
            '/mypage/detail' => ['controller' => 'Customer', 'action' => 'show'],
            '/mypage/edit' => ['controller' => 'Customer', 'action' => 'edit'],
            '/mypage/update' => ['controller' => 'Customer', 'action' => 'update'],
            '/mypage/delete' => ['controller' => 'Customer', 'action' => 'destroy'],
            // お気に入り
            '/mypage/favorites' => ['controller' => 'ProductFavorite', 'action' => 'index'],
            '/mypage/favorites/add\?product_id=\d+' => ['controller' => 'ProductFavorite', 'action' => 'store'],
            '/mypage/favorites/remove\?product_id=\d+' => ['controller' => 'ProductFavorite', 'action' => 'destroy'],
            // 購入履歴
            '/mypage/orders[\?period_beginning=[0-9a-zA-Z\-]*]*[\?*\*&period_ending=[0-9a-zA-Z\-]*]*[\&page=\d+]*' => ['controller' => 'Order', 'action' => 'index'],
            '/mypage/orders/confirm' => ['controller' => 'Order', 'action' => 'confirm'],
            '/mypage/orders/complete' => ['controller' => 'Order', 'action' => 'store'],
            // お問い合わせ履歴
            '/mypage/contact' => ['controller' => 'Contact', 'action' => 'index'],
            '/mypage/contact/send' => ['controller' => 'Contact', 'action' => 'send'],
            //
            // 管理者画面
            //
            '/admin' => ['controller' => 'Admin', 'action' => 'index'],
            '/admin/login' => ['controller' => 'Admin', 'action' => 'login'],
            '/admin/login/confirm' => ['controller' => 'Admin', 'action' => 'confirm'],
            '/admin/logout' => ['controller' => 'Admin', 'action' => 'logout'],
            // 顧客管理
            '/admin/customers/top' => ['controller' => 'Admin/Customer', 'action' => 'top'],
            '/admin/customers' => ['controller' => 'Admin/Customer', 'action' => 'index'],
            '/admin/customers\?id=\d+' => ['controller' => 'Admin/Customer', 'action' => 'show'],
            '/admin/customers/delete\?customer_id=\d+' => ['controller' => 'Admin/Customer', 'action' => 'destroy'],
            // 注文管理
            '/admin/orders/top' => ['controller' => 'Admin/Order', 'action' => 'top'],
            '/admin/orders[\?period_beginning=[0-9\-]*]*[\&period_ending=[0-9\-]*]*' => ['controller' => 'Admin/Order', 'action' => 'index'],
            // 商品
            '/admin/products/top' => ['controller' => 'Admin/Product', 'action' => 'top'],
            '/admin/products[\?category_id=\d+]*[\&page=\d+]*' => ['controller' => 'Admin/Product', 'action' => 'index'],
            '/admin/product/delete\?id=\d+' => ['controller' => 'Admin/Product', 'action' => 'destroy'],
            '/admin/product\?id=\d+' => ['controller' => 'Product', 'action' => 'show'],
            '/admin/product/register' => ['controller' => 'Admin/Product', 'action' => 'create'],
            '/admin/product/confirm' => ['controller' => 'Admin/Product', 'action' => 'store'],
            '/admin/product/register_completed' => ['controller' => 'Admin/Product', 'action' => 'store'],
            '/admin/products/store' => ['controller' => 'Product', 'action' => 'store'],
            '/admin/product/edit/\?id=\d+' => ['controller' => 'Admin/Product', 'action' => 'edit'],
            '/admin/product/update\?id=\d+' => ['controller' => 'Admin/Product', 'action' => 'update'],
            '/admin/product/update' => ['controller' => 'Admin/Product', 'action' => 'update'],
            // お問い合わせ履歴
            '/admin/contact' => ['controller' => 'Admin/Contact', 'action' => 'index'],
            '/admin/contact\?customer_id=\d+' => ['controller' => 'Admin/Contact', 'action' => 'show'],
            '/admin/contact/send' => ['controller' => 'Admin/Contact', 'action' => 'send'],
            // CSVインポート・エクスポート
            '/admin/csv_import\?data=[a-zA-Z]*' => ['controller' => 'Admin/CSV', 'action' => 'import'],
            '/admin/csv_import/execute' => ['controller' => 'Admin/CSV', 'action' => 'store'],
            '/admin/csv_export\?data=[a-zA-Z]*' => ['controller' => 'Admin/CSV', 'action' => 'export'],
            '/admin/csv_export/execute\?data=[a-zA-Z]*' => ['controller' => 'Admin/CSV', 'action' => 'download'],
        ];
    }

    private function render404Page()
    {
        $view = new View();
        $view->view(
            'Exceptions.404',
            []
        );
    }
}
