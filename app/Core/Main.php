<?php

namespace App\Core;

use ReflectionMethod;

class Main
{
    public function __construct(
        private Routeur $routeur =  new Routeur()
    ) {
    }
    public function start(): void
    {
        session_start();

        $uri = $_GET['q'];

        //on verifie le trailing /
        if ($uri != '' && $uri[-1] === '/') {

            //on enleve le dernier caractère
            $uri = substr($uri, 0, -1);

            http_response_code(302);
            header("Location: /$uri");
            exit();
        }
        $this->initRouteur();
        $this->routeur->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }

    private function initRouteur(): void
    {
        //on recupere dynamiquement tous les fichiers dans le dossier Controllers
        $files = glob(ROOT . '/Controllers/*.php');
        $filesSubFolder = glob(ROOT . '/Controllers/**/*.php');
        $files = array_merge_recursive($files, $filesSubFolder);

        //on boucle sur le tableau de fichiers
        foreach ($files as $file) {
            //enleve le premier /
            $file = substr($file, 1);

            //on remplace app par App
            $file = ucfirst($file);

            //on remplace / par \
            $file = str_replace('/', '\\', $file);

            //on enleve l'extension fichier
            $file = substr($file, 0, -4);

            $classes[] = $file;
        }

        foreach ($classes as $class) {
            //pour chaque classe on recupere la methode dans un tableau
            $methodes = get_class_methods($class);

            //on boucle sur les methodes de la classe
            foreach ($methodes as $methode) {
                //on recupere attributs php 8 pour chaque methode
                $attributs = (new \ReflectionMethod($class, $methode))->getAttributes(Route::class);

                foreach ($attributs as $attribut) {
                    //on cree une instance de la classe Route avec infos de attribut php8
                    $route = $attribut->newInstance();

                    //definir le controller pour la nouvelle route
                    $route->setController($class);

                    //on definit l'action de la route (methode a execute dans controller)
                    $route->setAction($methode);

                    //on ajoute la route dans tableau de Route
                    $this->routeur->addRoute([
                        'name' => $route->getName(),
                        'url' => $route->getUrl(),
                        'methods' => $route->getMethods(),
                        'controller' => $route->getController(),
                        'action' => $route->getAction(),
                    ]);
                }
            }
        }
    }
}
