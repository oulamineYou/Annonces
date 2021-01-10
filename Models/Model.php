<?php
namespace App_Olm\Models;
use App_Olm\Core\DataBase;
use PDOStatement;

class Model extends DataBase
{
    //le nom de table concerné
    protected $table;

    /**
     * le connecteur avec la base de données
     *
     * @var DataBase(PDO)
     */
    private $db;

    /**
     * ajouter un nouveau enregistrement a la table dans la base de données
     *
     * @param Model $model un enregistrement à ajouter
     * @return PDOStatement|false
     */
    public function create()
    {
        //parcourie le Model comme un tableau associatif 
        foreach($this as $key => $value)
        {
            //on élimine les attribue vide et les attribue table et db
            if( $value!==null && $key != 'table' && $key != 'db' ){
                $champs[] = $key;
                $inters[] = "?";
                $valeurs[] = $value ;
            }
        }

        $champ = implode(", ",$champs);
        $inter = implode(", ",$inters);

        //on exécute la requête d'insrtion
        return $this->require(
            "INSERT into " . $this->table . "( ".$champ . " ) values ( ". $inter . " )" ,
            $valeurs
        );
        
    }

    /**
     *le mise à jour d'un enregistrement
     *
     * @param Model $model un enregistrement à ajouter
     * @return PDOStatement|false
     */
    public function update()
    {
        //parcourie le Model comme un tableau associatif 
        foreach($this as $key => $value)
        {
            //on élimine les attribue vide et les attribue table et db
            if( $value!==null && $key != 'table' && $key != 'db' ){
                $champs[] = $key . " = ?";
                $valeurs[] = $value ;
            }
        }

        $champ = implode(", ",$champs);

        //on exécute la requête de mise à jour
        return $this->require(
            "UPDATE " . $this->table . " SET ".$champ ." where id = $this->id",
            $valeurs
        );
    }

    /**
     * supprimer un enregistrement id
     *
     * @param integer $id le clé de l'enregistrement à supprimé
     * @return PDOStatement|false
     */
    public function delete(int $id){
        return $this->require(
            "DELETE FROM " . $this->table . " where id = ". $id
        );
    }


    /**
     * hydratation des données
     *
     * @param $donnees Tableau associatif des données
     * @return self return l'objet hydraté
     */
    public function hydrate($donnees)
    {
        // On récupère le nom du setter correspondant à l'attribut.
        foreach($donnees as $key => $value)
        {
            $methode = "set". ucfirst($key);

            // Si le setter correspondant existe.
            if(method_exists($this,$methode))
            {
                // On appelle le setter.
                $this->$methode($value);
            } 
        }
        return $this;
    }


    /**
     * Méthode qui retournera tous les enregistrement de la table
     *
     * @return array tableau d'eregistrement trouvé
     */
    public function findAll()
    {
        //il return un tableau de tous les enregistrements
        return $this->require(
            "SELECT * from " . $this->table 
        )->fetchAll();
    }

    /**
     * trouvera tous les enregistrement qui vérifient les critiéres indésuer 
     *
     * @param array $critiers un tableua associatif de critier attr=>valeur
     * @return array un tableau d'enregistrement 
     */
    public function findBy(array $critiers)
    {
        foreach ($critiers as $key => $value) {
            //on met les nom des attributs dans le tableau sous forme de attribut = ?
            $attr[]   = $key .' = ? ';
            //on met les valeur dans un tableau séparé
            $valeur[] = $value; 
        }

        $str = implode(" AND ", $attr );
        
        //il return un tableau des enregistrements
        return $this->require(
               "SELECT * from " . $this->table . " where ". "$str",
                $valeur
            )->fetchAll();
    }

    /**
     * trouvrera un enregistrement id
     *
     * @param integer $id le clé de l'enredgistrement
     * @return objet|bool un enregistrement sous forme objet ou faux s'il n'exist pas
     */
    public function find(int $id){
        //il return un enregistrement
        return $this->require(
            "SELECT * from " . $this->table . " where id = ". $id
        )->fetch();
    }
    
    /**
     * Méthode qui exécutera les requêtes
     *
     * @param String $sql la requete à exécuté
     * @param array $attributes les attributs a ajouter à la requête
     * @return PDOStatement|false
     */
    public function require(String $sql, array $attributes = null)
    {
        $this->db = self::getInstance();
        
        if($attributes === null){
            //Requête Simple
            return $this->db->query($sql);
        }else{
            //Requête preparé
            $statement = $this->db->prepare($sql);
            $statement->execute($attributes);
            return $statement;
        }
    }


}
?>