<?php

namespace App\Core;

class Main
{
    public function __construct(
        private Router $router = new Router
    ) {
    }

    public function start(): void
    {
        $uri = $_SERVER['REQUEST_URI'];

        if ($uri !== '/' && !empty($uri) && $uri[-1] === '/') {
            $uri = substr($uri, 0, -1);

            http_response_code(302);

            header("Location: $uri");
            exit();
        }

        $this->router->initRouter();

        $this->router->handleRequest($uri, $_SERVER['REQUEST_METHOD']);
    }
}
