<?php
namespace App_Olm\Controllers;

use App_Olm\Models\Annonce;

class AdminController extends Controller
{
    /**
     * page d'accueil de l'administrateur
     *
     * @return void
     */
    public function index()
    {
        if($this->isAdmin())
        {
            $this->render("admin/index.php");
        }
    }

    /**
     * gestions des annonces
     *
     * @return void
     */
    public function annonces()
    {
        if($this->isAdmin())
        {
            //on créera une instance d'annonce
            $annanceModel = new Annonce;
            //on extrait tous les annances de site
            $annonceArray = $annanceModel->findAll();
            
            usort($annonceArray,"App_Olm\Models\Annonce::orderByDateCreation");
            //on envoyera la liste des annonces au page annoces.php
            $this->render("/admin/annonces.php",compact('annonceArray'));
        }
    }

    /**
     * modifier l'etat d'un annonce
     *
     * @param int $id
     * @return void
     */
    public function activeAnnonce(int $id)
    {
        if($this->isAdmin())
        {
            $annanceModel = new Annonce;
            $annonceArray = $annanceModel->find($id);

            $annanceModel->hydrate($annonceArray);
            $annanceModel->setActif( ($annanceModel->getActif())? 0 : 1);
            $annanceModel->update();
            
        }
    }

    /**
     * testera si l'utilisateur est connécté en tant qu'admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        //testera si l'utilisateur est connécté 
        //et parmis ses roles le role d'admin 
        if(isset($_SESSION['user']) && in_array('ROLES_ADMIN',$_SESSION['user']['roles']))
        {
            return true;
        }
        // si l'utilisateur n'est pas connecté ou n'est pas un administrateur
        else
        {
            $_SESSION['error'] = 'vous devez être connécter en tant qu\' administrateur pour accéder à cette page';
            header("Location: /");
        }
    }
}

