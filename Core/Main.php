<?php
namespace App_Olm\Core;

use App_Olm\Controllers\MainController;

/**
 * nous permet de router les demandes vers les différents contrôleurs
 * Nous devons récupérer les paramètres d'URL (p=controleur/méthode), 
 * vérifier si ils existent et enfin charger le contrôleur et la méthode concernés.
 */
class Main
{
    public function start()
    {
        //on démare le session
        session_start();
        
        //on récupére l'adresse
        $uri = $_SERVER['REQUEST_URI'];
        
        //on supprime le dernier / s'il existe & la fin de notre url ( /controlleur/model/ )
        if($uri != "" && $uri[-1]==="/" && $uri!=="/")
        {
            //on enleve le / de la fin de url
            $uri = substr($uri, 0, -1);

            //On envoie une redirection permanente
            http_response_code(301);
        
            //on redérige vers l'URL dans /
            header("Location: ".$uri);
            exit;
        }
        //on transfére l'url à un tableau de paramétre
        if(isset($_GET['p']))
            $param = explode('/', $_GET['p']);

        //si le tableau de paramétres n'est pas vide
        if(!empty($param[0]))
        {
            //on prend le premier parametre et on lui ajoute le Contôleur avec le namespace complet
            // example si le param[0] = main, il transformer au App_Olm\Controllers\MainController
            $controler = '\\App_Olm\\Controllers\\'.ucfirst(array_shift($param)).'Controller';
            
            //on prend le deuxiem paramétre s'il exidt comme un action du Contrôleur
            $action = isset($param[0])? array_shift($param): 'index';
            
            //on instancie le Contrôleur
            $controler = new $controler;

            //si la méthode exist dans le contrôleur, on l'apple
            if(method_exists($controler, $action))
            {
                // Si il reste des paramètres, on appelle la méthode en envoyant les paramètres sinon on l'appelle "à vide"
                (isset($param[0]))? call_user_func_array([$controler, $action], $param) : $controler->$action();
            }else{
                //ici la méthode n'existe pas
                //on envoie un message d'erreur
                http_response_code(404);
                echo "cette page n'existe pas";
            }
        }
        else{
            // Ici aucun paramètre n'est défini
            // On instancie le contrôleur par défaut (page d'accueil)
            $controler = new MainController;

            // On appelle la méthode index
            $controler->index();
        }
    }
}

?>