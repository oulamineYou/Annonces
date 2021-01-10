<?php
namespace App_Olm\Controllers;

class Controller  
{
    /**
     * afficher une vue
     *
     * @param String $fichier le fichier à afficher
     * @param array $data les données associés
     * @return void
     */
    public function render(String $fichier, array $data=[],String $template = "default.php")
    {
        //récupérera les données et les extraire sous formes des variables
        extract($data);

        //on redémare le buffer de sortie
        ob_start();

        //Créer le chemin et inclus le fichier de vue
        require_once(ROOT."/Views/".$fichier);

        //on stock le contenue du buffer dans $content
        $content = ob_get_clean();

        //on inclus notre template
        require_once(ROOT."/Views/".$template);
    }
    
}


?>