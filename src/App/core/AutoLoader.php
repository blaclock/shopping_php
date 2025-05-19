<?php

namespace App\core;

class AutoLoader
{
    private $dirs;

    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    public function registerDir($dir)
    {
        $this->dirs[] = $dir;
    }

    private function loadClass($className)
    {
        // namespaceを使ってもオートロードができるように
        $fileName = $this->getLoadFileName($className);

        foreach ($this->dirs as $dir) {
            $file = $dir . '/' . $fileName . '.php';
            if (is_readable($file)) {
                require_once $file;
                // return;
            }
        }
    }

    private function getLoadFileName($className)
    {
        $filePath = explode('\\', $className);
        $fileName = $filePath[array_key_last($filePath)];
        return $fileName;
    }
}
