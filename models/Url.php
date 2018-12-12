<?php
/**
 * Created by PhpStorm.
 * User: lpiem
 * Date: 07/11/2018
 * Time: 15:03
 */

class Url{

    private $conn;
    private $id_url;
    private $libelle;

    //Constuctor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //create pokemon
    public function create() {
        //create query
        $query = 'INSERT INTO url (libelle) VALUES (:libelle)';
        //prepare statement
        $stmt = $this->conn->prepare($query);

        //BIND data
        //$stmt->bindParam(':id_type', $this->id_pokemon);
        $stmt->bindParam(':libelle', $this->libelle);


        //execute query
        if($stmt->execute()){
            return true;
        }

        printf("Error : %s.\n",$stmt->error);

        return false;

    }

    //Get 1 url
    public function read_one($id) {
        //create query
        $query = 'Select libelle from url where id_url = ' . $id;

        //prepare statement
        $stmt = $this->conn->prepare($query);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->setIdUrl($row['id_url']);
        $this->setLibelle($row['libelle']);

        //execute query
        $stmt->execute();

        return $stmt;
    }



    /**
     * @return mixed
     */
    public function getIdUrl()
    {
        return $this->id_url;
    }

    /**
     * @param mixed $id_url
     */
    public function setIdUrl($id_url)
    {
        $this->id_url = $id_url;
    }

    /**
     * @return mixed
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }






}