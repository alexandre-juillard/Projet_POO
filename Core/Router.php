<?php

namespace App\Core;

use App\Core\Route;

class Router
{
    public function __construct(
        private array $routes = []
    ) {
    }

    public function addRoute(array $route): self
    {
        $this->routes[] = $route;

        return $this;
    }

    public function handleRequest(string $url, string $method): void
    {
        foreach ($this->routes as $route) {
            if ($url === $route['url'] && in_array($method, $route['methods'])) {
                $controllerName = $route['controller'];
                $actionName = $route['action'];

                $controller = new $controllerName();
                $controller->$actionName();

                return;
            }
        }

        http_response_code(404);
        echo "Page not found";
    }

    public function initRouter(): void
    {
        $files = glob(ROOT . '/Controllers/*.php');
        $subFiles = glob(ROOT . '/Controllers/*/*.php');
        $files = array_merge_recursive($files,  $subFiles);

        foreach ($files as $file) {
            // On enlève le permier /
            $file = substr($file, 1);

            $file = str_replace('/', '\\', $file);

            $file = substr($file, 0, -4);

            $file = ucfirst($file);

            $classes[] = $file;
        }

        foreach ($classes as $class) {
            $methods = get_class_methods($class);

            foreach ($methods as $method) {
                $attributes = (new \ReflectionMethod($class, $method))
                    ->getAttributes(Route::class);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();

                    $route->setController($class);
                    $route->setAction($method);

                    $this->addRoute([
                        'url' => $route->getUrl(),
                        'name' => $route->getName(),
                        'methods' => $route->getMethods(),
                        'controller' => $route->getController(),
                        'action' => $route->getAction(),
                    ]);
                }
            }
        }
    }
}
