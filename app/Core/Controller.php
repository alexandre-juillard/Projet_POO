<?php

namespace App\Core;

abstract class Controller
{
    protected function render(string $path, array $data = []): void
    {
        extract($data);

        ob_start();

        require_once ROOT . '/Views/' . $path;
        
        $content = ob_get_clean();

        require_once ROOT . '/Views/base.php';
    }
}