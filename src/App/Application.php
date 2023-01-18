<?php

class Application
{
    protected $request;
    protected $router;
    protected $response;
    protected $model;

    public function __construct()
    {
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
        // namespaceで名前空間を定義しているので、コントローラーで定義されている名前空間を結合する
        $controllerClass = 'App\\controllers\\' . ucfirst($controllerName) . 'Controller';
        // コントローラーがない場合に例外を投げる
        if (!class_exists($controllerClass)) {
            throw new HttpNotFoundException();
        }

        $controller = new $controllerClass($this);
        $controller->run($action);
    }

    private function registerRoutes()
    {
        // ルーティングのパターンを登録
        return [
            '/' => ['controller' => 'Product', 'action' => 'index'],
            // 商品表示
            '/products[\?category_id=\d+]*[\&page=\d+]*' => ['controller' => 'Product', 'action' => 'index'],
            '/products\?q=[0-9０-９a-zA-Zぁ-んーァ-ヶー一-龠\-\|\s]*[\&page=\d+]*' => ['controller' => 'Product', 'action' => 'search'],
            '/product\?id=\d+' => ['controller' => 'Product', 'action' => 'show'],
            '/products/register' => ['controller' => 'Product', 'action' => 'create'],
            '/products/confirm' => ['controller' => 'Product', 'action' => 'confirm'],
            '/products/store' => ['controller' => 'Product', 'action' => 'store'],
            '/products/\?id=\d+/edit' => ['controller' => 'Product', 'action' => 'edit'],
            // レビュー
            '/product/review\?product_id=\d+' => ['controller' => 'Review', 'action' => 'create'],
            '/product/review/store' => ['controller' => 'Review', 'action' => 'store'],
            // カート
            '/cart' => ['controller' => 'Cart', 'action' => 'index'],
            '/cart/add' => ['controller' => 'Cart', 'action' => 'store'],
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
            '/mypage' => ['controller' => 'Customer', 'action' => 'index'],
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
            '/mypage/orders' => ['controller' => 'Order', 'action' => 'index'],
            '/mypage/orders/store' => ['controller' => 'Order', 'action' => 'store'],

        ];
    }

    private function render404Page()
    {
        $view = new View();
        $view->view('Exceptions.404', [
            'categories' => $this->model->get('Product')->getCategoryList()
        ]);
    }
}
