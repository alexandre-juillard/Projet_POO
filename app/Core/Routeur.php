<?php

namespace App\Core;

class Routeur
{
    public function __construct(
        private array $routes = [],
    )
    {
        
    }

    public function addRoute(array $route): self
    {
        $this->routes[] = $route;

        return $this;
    }

    public function handleRequest(string $url, string $method): void
    {
        //on boucle sur les routes de l'application
        foreach($this->routes as $route) {
            //verif que url du client correspond a url de la route 
            //et methode http client correspond a celle de la route
            if(preg_match("#^" . $route['url'] . "$#", $url, $matches) && in_array($method, $route['methods'])) {
                //on recuperer nom du controller
                $controller = $route['controller'];

                //on recupere nom de methode a executer
                $action = $route['action'];

                //instancier le controller
                $controller = new $controller();

                //on recupere parametres d'url
                $params = array_slice($matches, 1);

                //on execute methode dans le controller
                $controller->$action(...$params);

                return;
            }
        }

        http_response_code(404);
        echo "Page not found";
    }
    
}