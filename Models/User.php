<?php

namespace App_Olm\Models;

class User extends Model
{
    protected int $id_user;
    protected String $email;
    protected String $password;
    protected $roles;

    public function __construct()
    {
        $this->table = "USER";
    }

    /**
     * retournera l'enregistrement correspond à un email
     *
     * @param String $email
     * @return object|bool
     */
    public function findOneEmail(String $email)
    {
        return $this->require(
            "select * from user where email = ? ", [$email]
        )->fetch();
    }

    /**
     * mettre le user actuel dans la session
     *
     * @return void
     */
    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id_user,
            'email' => $this->email,
            'roles' => $this->roles
        ];
        
    }
    /**
     * supprimer l'utilisateur par session
     *
     * @return void
     */
    public function destroySession()
    {
        unset($_SESSION['user']);
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of id_user
     */ 
    public function getId_user()
    {
        return $this->id_user;
    }

    /**
     * Set the value of id_user
     *
     * @return  self
     */ 
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * Get the value of roles
     */ 
    public function getRoles()
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    /**
     * Set the value of roles
     *
     * @return  self
     */ 
    public function setRoles($roles)
    {
        $this->roles = json_decode($roles);
        return $this;
    }
}


?>