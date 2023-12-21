<?php

namespace App\Core;

abstract class Controller
{
    public function render(string $path, array $data = []): void
    {
        extract($data);

        include_once ROOT . '/Views/' . $path;
    }
}
