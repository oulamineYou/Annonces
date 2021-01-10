<?php

namespace App_Olm\Controllers;

use App_Olm\Core\Form;
use App_Olm\Models\User;

class UsersController extends Controller
{
    /**
     * gérer l'authentification d'un utilisateur 
     *
     * @return void
     */
    public function login()
    {
        $form = new Form;

        //testera le passage des champs par le Post et tester si les champs ne sont pas vide
        if(isset($_POST['email']) && isset($_POST['password']) && $form->validate($_POST, ["email", "password"]))
        {
            //nettoyade de contenue d'email
            $email = strip_tags($_POST['email']);
            
            $userModel = new User();
            $user = $userModel->findOneEmail( $email );

            if(!$user){
                $_SESSION['error'] = "Email ou password est incorrecte";
            }
            else{
                if( password_verify($_POST['password'], $user->password))
                {
                    $userModel->hydrate($user);
                    $userModel->setSession();    
                    if(in_array("ROLES_ADMIN",  $_SESSION['user']['roles']))
                        header("Location: /admin");
                    else header("Location: /annonces");
                }else
                {
                    $_SESSION['error'] = "Email ou password est incorrecte";
                }
            }
        }


        $form->startForm("POST","#",["class"=>"mt-4 row mx-2"])
                ->addInput('email','email', ['class'=>'form-control  my-2','required'=>true, 'Placeholder' => "email"])
                ->addInput("password","password",['class'=>'form-control  my-2','required'=>true, 'Placeholder' => "PassWord"])
                ->addButton("me connecter", ["type"=>"submit", "class"=>"my-3 offset-md-0 btn btn-primary"])    
            ->endForm() 
            ;
        $form = $form->create();
        $this->render("users/login.php", compact('form'));
    }

    /**
     * formulaire pour s'inscrir au notre applicatio comme un utilisateur
     *
     * @return void
     */
    public function register()
    {
        $form = new Form;
        
        //tester le passage des champs par le Post
        if(  isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password-verified']) ) 
        {
            //Nettoyage de contenue d'email
            $email = strip_tags($_POST['email']);

            $pass = $_POST['password'];
            $verified_pass = $_POST['password-verified'];
                        
            //vérifier la validation d'email et password
            if( Form::validateEmail($email) && Form::validatePassword($pass) )
            {
                //comparer les deux password
                if(strcmp($pass, $verified_pass) == 0)
                {
                    //si les passwords sont identiques
                    //on crupte le mot de passe
                    $pass = password_hash($pass, PASSWORD_ARGON2I);

                    $user = new User();
                    $user->setEmail($email)
                        ->setPassword($pass);
                    $user->create();
                    header("Location: /users/login");
                }
                else $_SESSION["non_identique_password"] = "vous devez insérer la même password";
            }
        }
        
        $form->startForm();
        
        //on crée l'input d'email
        $form->addInput('email','text', ['class'=>'form-control  my-2','required'=>true, 'id'=>'email','Placeholder' => "email"]);
        //si l'email n'est pas vlide on va afficher une alert pour informer l'utilisateur
        if(isset($_SESSION["email_invalide"]))
        {
            //on créer une Div ,avec un classe boostrap alert, qui contient le message d'erreur 
            $form->startDiv(["class" => "alert alert-danger mt-0", "role"=>"alert"], $_SESSION["email_invalide"]);
            unset($_SESSION["email_invalide"]);
            $form->endDiv();
        }

        //on crée l'input de password
        $form->addInput("password","password",['class'=>'form-control  my-2','required'=>true,'id'=>'password', 'Placeholder' => "Taper un mot de passe "]);
        //si le format de password n'est pas vlide on va afficher une alert pour informer l'utilisateur
        if(isset($_SESSION["password_invalide"]))
        {
            //on créer une Div ,avec un classe boostrap alert, qui contient le message d'erreur 
            $form->startDiv(["class" => "alert alert-danger mt-0", "role"=>"alert"], $_SESSION["password_invalide"]);
            unset($_SESSION["password_invalide"]);
            $form->endDiv();
        }
        
        //on crée l'input de vérifier password 
        $form->addInput("password-verified", "password", ['class'=>'form-control  my-2', 'id'=>'password-verified', 'required'=>true, "placeholder"=>"retapez votre mot de passe"]);
        //si le passwrd est différent de premier  on va afficher une alert pour informer l'utilisateur
        if(isset($_SESSION["non_identique_password"]))
        {
            //on créer une Div ,avec un classe boostrap alert, qui contient le message d'erreur 
            $form->startDiv(["class" => "alert alert-danger mt-0", "role"=>"alert"], $_SESSION["non_identique_password"]);
            unset($_SESSION["non_identique_password"]);
            $form->endDiv();
        }
        
        //on crée le button de submit
        $form->addButton("enregistrer", [ "class"=>"my-3 offset-md-0 btn btn-primary btn-block"])   
            ->endForm() 
            ;
        $form = $form->create();    
        
        $this->render("users/register.php", compact('form'));
    }
    
    public function logout()
    {
        $user = new User();
        $user->destroySession();
        header("Location: /users/login");
    }
} 
?>