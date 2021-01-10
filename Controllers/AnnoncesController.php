<?php
namespace App_Olm\Controllers;

use App_Olm\Core\Form;
use App_Olm\Models\Annonce;


class AnnoncesController extends Controller
{
    /**
     * afficher la liste des annonces
     *
     * @return void
     */
    public function index()
    {
        //on instancie un annonce
        $annonces = new Annonce;

        //on récupérer tous les annonces
        $annonces = $annonces->findAll();
        
        usort($annonces,"App_Olm\Models\Annonce::orderByDateCreation");

        //on trasmettra le nom de vue et l'ensemble des annonces à la fonction rendre pour les affichier 
        $this->render("annonces/index.php",compact("annonces"));
        
    }

    /**
     * afficher les détai su une annonce
     *
     * @param integer $id l'id de l'annonce à affiché
     * @return void
     */
    public function annonce(int $id)
    {
        //on instancie un objet d'annonce
        $annonce = new annonce;
        
        //on récupére l'annonce de l'id correspont au l'id de fonction
        $annonce = $annonce->find($id);

        $this->render("annonces/annonce.php",compact("annonce"));
    }

    /**
     * ajouter une annonce
     *
     * @return void
     */
    public function add()
    {
        //s'il y a des données envoyé par le post on les mettrera dans les variable aprés les nettoyer par strip_tags
        //sinon on met des chaines vides    
        $titre = (isset($_POST['titre'])) ? strip_tags($_POST['titre']) : "";
        $description = (isset($_POST['description'])) ? strip_tags($_POST['description']) : "";

        //on teste la validation de toutes les champs
        if( Form::validate($_POST, ["titre","description"]))
        {
            //on crée une instance d'annance
            $annonce = new Annonce();
            
            //on hydrate les données
            $annonce->setTitre($titre)
                    ->setDescription($description)
                    ->setUser_id($_SESSION['user']["id"]);
            
                    //on met l'annonce au base de données
            $annonce->create();

            //on redige vers la page de liste des annonces
            $_SESSION['success'] = "votre annonce a été enregistrer avec success";
            header("Location: /annonces/");
        }

        //on instancier un objet de Type Form
        //permer de créer un form
        $form = new Form();

        //créer le form d'ajout des annonces
        $form->startForm()
                ->addLabel("titre","titre")
                ->addInput("titre","text",["class"=>"form-control", "id"=>"titre", "value"=>$titre , "required" => true])
                ->addLabel("description","description")
                ->addTextarea("description",8,100, $description,["class"=>"form-control", "id"=>"description"])
                ->addButton("ajouter",["type"=>"submit", "class"=>"btn btn-primary my-3"])
            ->endForm();
        $form = $form->create();
        $this->render("annonces/add.php", compact("form"));
    }
    /**
     * modifier les informations d'un annance 
     *
     * @param integer $id l'id de l'annonce à modifié
     * @return void
     */
    public function update(int $id)
    {
        //on crée une instance d'annance
        $annonce = new Annonce();

        //on teste la validation de toutes les champs
        if( Form::validate($_POST, ["titre","description"]))
        {
            //on ettoyera les données reçu
            $titre = strip_tags($_POST['titre']);
            $description = strip_tags($_POST['description']);
            $annonce->setTitre($titre)
                    ->setDescription($description)
                    ->setId($id);
            $annonce->update();
            
            $_SESSION['success'] = "l'annonce de $titre est bien modifié ";
            
            if(in_array("ROLES_ADMIN", $_SESSION['user']['roles']))
                header("Location: /admin/annonces");
            else header("Location: /annonces/");
        } 
        //trouver l'annonce de l'id $id 
        $annonce = $annonce->find($id);

        //si l'annonce n'exist pas 
        if(!$annonce)
        {
            $_SESSION['error']="l'annonce demandé n'exist pas";
            header("Location: /annonces/");
        }
        //si il y a un annace a le id $id
        else{
            //on teste si l'utilisateur actuel est le créateure d'annonce ou l'utisateur est un administrateur 
            if($_SESSION['user']['id'] == $annonce->user_id || in_array('ROLES_ADMIN', $_SESSION['user']['roles']))
            {
                //on instancier un objet de Type Form
                //permer de créer un form
                $form = new Form();

                //créer le form d'ajout des annonces
                $form->startForm()
                        ->addLabel("titre","titre")
                        ->addInput("titre","text",["class"=>"form-control", "id"=>"titre", "value"=> $annonce->titre , "required" => true])
                        ->addLabel("description","description")
                        ->addTextarea("description",8,100, $annonce->description,["class"=>"form-control", "id"=>"description"])
                        ->addButton("ajouter",["type"=>"submit", "class"=>"btn btn-primary my-3"])
                    ->endForm();
                $form = $form->create();
                
                $this->render("annonces/add.php", compact("form"));
            }
            //si l'utilisateur n'a pas de permission 
            else{
                $_SESSION['error'] = "vous n'avez le permission de modifier l'annonce $id";
                header("Location: /annonces");
            }
        }
    }

    public function delete(int $id)
    {
        //on crée une instance d'annance
        $annonceModel = new Annonce();   
        //trouver l'annonce de l'id $id 
        $annonce = $annonceModel->find($id);
        if(!$annonce)
        {
            $_SESSION['error']="l'annonce demandé n'exist pas";
            header("Location: /annonces/");
        }
        //si il y a un annace a le id $id
        else{
            //on teste si l'utilisateur actuel est le créateure d'annonce
            if($_SESSION['user']['id'] == $annonce->user_id || in_array('ROLES_ADMIN', $_SESSION['user']['roles']))
            {
                //on supperimera l'annonce
                $annonceModel->delete($id);
                //on met un message de succes
                $_SESSION['success']="l'annonce de {$annonce->titre} est bien supprimé";
                //on retourne à la page des annances
                if(in_array("ROLES_ADMIN", $_SESSION['user']['roles']))
                    header("Location: /admin/annonces");
                else header("Location: /annonces/");
            }
            //si l'utilisateur n'a pas de permission 
            else{
                $_SESSION['error'] = "vous n'avez le permission de supprimer l'annonce $id";
                header("Location: /annonces");
            }
        }
    }

}


?>