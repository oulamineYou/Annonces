<?php

namespace App_Olm;

class Autoload {

    /**
     * il ajoute un fonction à file d'attente d'autochargement
     *
     * @return void
     */
    public static function register()
    {     
        /**
         * la fonction spl_autoload_register va ajouter notre fonction autload à la file d'attente des fonctions d'autochargement
         */
        spl_autoload_register([
            __CLASS__,
            'autoload'
        ]);
    }

    /**
     * il appele les nomes des classes utiliser
     *
     * @param String $class
     * @return void
     */
    static function autoload($class){
        /**
         * le variable $class va contenir le namespace de la classe conserné
         * example App_OLm\Banque\Compte
         */

        /**
         * on supprimer le name space App_OLm
         * alors in va reste selon notre example \Banque\Compte
         */
        $class = str_replace(__NAMESPACE__,'',$class);

        /**
         * on replace \ par / et 
         * alors in va reste selon notre example /Banque/Compte
         */
        $class = str_replace('\\','/',$class);
        
        //on ajoute le docissier de nos classes et l'extention .php de notre fichier
        $fichier = __DIR__.$class.'.php';

        //on teste l'existence de fichier
        if(file_exists($fichier))
            require_once $fichier;
    }
}
?>