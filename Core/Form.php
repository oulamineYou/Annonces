<?php

namespace App_Olm\Core;

class Form
{
    private $form ;

    public function create(){
        return $this->form;
    }

    /**
     * ajouter des attributs à un élément HTML
     *
     * @param array $attributes les attribuues à ajouté
     * @return Form
     */
    public function setAttribute(array $attributes = []):self
    {
        //les attribues sans valeur
        $default_attributes = [
            "required",
            "readonly",
            "disabled",
            "multiple",
            "autofocus"
        ];

        //parcourir tous les attribues passé par les paramétres 
        foreach ($attributes as $attribute => $value) {
            //si l'attribue existe dans le default_attributes
            if(in_array($attribute,$default_attributes))
                //on va ajouté l'attribue au notre form si sa valeur est true sinon on ajoute rien
                $this->form .= ($attribute)? " $attribute": "";
            else
            //si l'attribue n'existe pas dans la tableu default_attributes
                //on ajoutera l'attribue avec sa valeur 
                $this->form .= " $attribute = '$value'";
        }
        return $this;
    }

    /**
     * En commance le form
     *
     * @param string $methode methode de l'envoie de données (POST, GET,..)
     * @param string $action    le fichier qui va prendre les doonnées 
     * @param array $attributes les attributs de balise form
     * @return Form
     */
    public function startForm(string $methode = 'POST' ,string $action = '#',array $attributes = []):self
    {
        $this->form .= " <form method=\"$methode\" action='$action' " ;
        $this->setAttribute($attributes);
        $this->form .= ">";
        return $this;
    }

    /**
     * créera un div
     *
     * @param array $attributes les attribues a ajouter (class =>"", id=>"")
     * @param String $content le contenue de div (optionnel)
     * @return self
     */
    public function startDiv(array $attributes = [],String $content = ""):self
    {
        $this->form .= " <div  " ;
        $this->setAttribute($attributes);
        $this->form .= ">";
        $this->form .= $content;
        return $this;
    }

    /**
     * fermer le div
     *
     * @return void
     */
    public function endDiv()
    {
        $this->form .= "</div>";
        return $this;
    }

    /**
     * ajouter un label au Form
     *
     * @param String $for 
     * @param string $text le text de label
     * @param array $attributes les attribues a ajouter (class =>"", id=>"")
     * @return Form
     */
    public function addLabel(String $for,string $text, array $attributes = []):self
    {
        $this->form .= " <label for='$for'";
        $this->setAttribute($attributes);
        $this->form .= " > $text </label>";
        return $this;
    }

    /**
     * ajouter un iput au Form
     *
     * @param String $name le name d'input
     * @param String $type le type d'input
     * @param array $attributes les attribues a ajouter (class =>"", id=>"")
     * @return Form
     */
    public function addInput(String $name, String $type,array $attributes = []):self
    {
        $this->form .= " <input name='$name' type='$type'";
        $this->setAttribute($attributes);
        $this->form .= " />";
        return $this;
    }
    /**
     * ajouter un textarea au form
     *
     * @param String $name le nom de textarea
     * @param integer $rows le nombre de ligne visible (par defaut 4)
     * @param integer $cols le width visible (par défaut 100)
     * @param String $content le contenu de le textArea
     * @param [type] $attributes les attribues a ajouter (class =>"", id=>"")
     * @return Form
     */
    public function addTextarea(String $name,int $rows = 4, int $cols =100,String $content="",array $attributes = [])
    {
        $this->form .= "<textarea name=\"$name\" rows=$rows cols=$cols ";
        $this->setAttribute($attributes);
        $this->form .= ">";
        $this->form .= (empty($content))? "</textarea>" : "$content </textarea>"; 
        return $this;
    }

    /**
     * ajouter un button
     *
     * @param String $text le text de butuon (ajouter, supprimer, update ...)
     * @param array $attributes les attribues a ajouter (class =>"", id=>"")
     * @return Form
     */
    public function addButton(String $text, array $attributes = []):self
    {
        $this->form .= " <button ";
        $this->setAttribute($attributes);
        $this->form .= " > $text </button>";
        return $this;
    } 

    /**
     * terminer le Form (balise ferment du Form)
     *
     * @return Form
     */
    public function endForm():self
    {
        $this->form .= "</form>";
        return $this;
    }

    /******************************************* les fonctions de validation de champs **********************************************/
    
    /**
     *vérifiera que les variables ne sont pas vide
     * @param array $methode la methode de l'envoie de données (POST ou GET)
     * @param array $keys les valeur stockey (example email, password ... sous forme de $_Post['email'])
     * @return bool
     */
    public static function validate(array $methode,array $keys ):bool
    {
        foreach ($keys as $key) {
            if(empty($methode[$key])){
                return false;
            }
        }
        return true;
    }

    /**
     * vérifier le format d'email
     * format d'email est chaine@chaine.chaine
     *
     * @param String $email
     * @return bool
     */
    public static function validateEmail(String $email):bool
    {
        //tester est ce que l'email sous forme de chaine@chaine.chaine
        if(preg_match("#^[A-Za-z][A-Za-z0-9_.-]*@[A-Za-z1-9]+\.[A-Za-z1-9]+#" ,$email))
            return true;
        else{
            $_SESSION['email_invalide'] = "l'email doit être sous forme name@name.name";
            return false;
        }
            
    }

    /**
     * validate le format de password
     * critiére à suivre :
     * ********* contient au moin un lettre majuscule et un lettre minuscule
     * ********* contient au moin un nombre et un symbole
     * ********* contient au moins 8 charactére
     *    
     * @param String $password
     * @return bool
     */
    public static function validatePassword(String $password):bool
    {
        /**
         * on testera que le password contient au moins 8 charctére
         * 
         * ctype_alnum : testera si la chaine ne contienne que des alphanumérique pas de symboles
         */
        if(strlen($password)>=8 )
        {
            //tester si la chaine contient au moins une chiffre 
            if( preg_match("#[0-9]#", $password) )
            {

                //testera si la chaine contienne au moins une lettre Majuscule
                if( preg_match("#[A-Z]#", $password) ){
                    //testera si la chaine contienne au moins une lettre minuscule
                    if( preg_match("#[a-z]#", $password))
                    {
                        //testera si la chaine contient au moins un symbole
                        if(!ctype_alnum($password))    
                            return true;
                        //si la chaine ne contient aucun symbole
                        else $_SESSION['password_invalide'] = "le mot de passe doit contient au moins un Symbole";
                    }
                    //si la chaine ne contient aucune lettre majuscule
                    else $_SESSION['password_invalide'] = "le mot de passe doit contient au moins une lettre miniscule";
                }
                //si la chaine ne contient aucune lettre minuscule
                else $_SESSION['password_invalide'] = "le mot de passe doit contient au moins un lettre majucule";
            }
            //si la chaine ne contient aucun nombre
            else $_SESSION['password_invalide'] = "le mot de passe doit contient au moins un chiffre";
        }
        //si la longueur de la chaine inférieur de 8
        else $_SESSION['password_invalide'] = "le mot de passe doit contient au moins 8 caractéres";
        
        return false;
    }      
}
?>