<?php

namespace App\Core;

abstract class Controller
{
    public function render(string $path, array $data = []): void
    {
        extract($data);

        ob_start();

        require_once ROOT . '/Views/' . $path;

        $contenu = ob_get_clean();

        require_once ROOT . '/Views/base.php';
    }

    public function addFlash(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;
    }
}
