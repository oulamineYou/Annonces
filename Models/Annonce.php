<?php

namespace App_Olm\Models;


class Annonce extends Model{
    protected $id;
    protected $titre;
    protected $description;
    protected $actif;
    protected $created_at ;
    protected $user_id;

    //on mettra le nom d'objet dans 
    public function __construct(){
        $this->table = 'ANNONCE';
    }

    /**
     * trier par order décroissant
     *
     * @param Annonce $Obj1
     * @param Annonce $Obj2
     * @return int
     */
    public static function orderByDateCreation($Obj1,$Obj2):int
    {
        $date1 = $Obj1->created_at;
        $date2 = $Obj2->created_at;
        //si les dates sont identique on retourn 0
        if($date1 == $date2)    
            return 0;
        else {
            //si le date de premier inférieur à deuxieme on returne 1
            if($date1 < $date2)
                return 1;
            //si le date de premier supérier à deuxieme on returne 1
            else return -1;
        }
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of actif
     */ 
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set the value of actif
     *
     * @return  self
     */ 
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of titre
     */ 
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @return  self
     */ 
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }
}

?>