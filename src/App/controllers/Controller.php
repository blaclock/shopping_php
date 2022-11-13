<?php

use eftec\bladeone\BladeOne;

class Controller
{
    public function view(string $filePath, array $variables)
    {
        $views = __DIR__ . '/../../resources/views/'; // テンプレートパス
        $cache = __DIR__ . '/../../resources/cache/'; // キャッシュパス(コンパイル済ファイル)

        $blade = new BladeOne($views, $cache, \eftec\bladeone\BladeOne::MODE_DEBUG);

        // レンダリング
        echo $blade->run($filePath, $variables);
    }
}
