<?php

namespace App\Core;

class Main 
{
    public function start(): void 
    {
        $uri = $_GET['q'];

        //on verifie le trailing /
        if($uri != '' && $uri[-1] === '/') {

            //on enleve le dernier caractère
            $uri = substr($uri, 0, -1);
            
            http_response_code(302);
            header("location: /$uri");
            exit();
        }
        echo 'Hello world depuis methode start';
    }
}           