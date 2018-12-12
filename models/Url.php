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


    public function read_one() {
        //create query
        $query = 'Select * from url where id_url = ? LIMIT 0,1';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //BIND id
        $stmt->bindParam(1, $this->id_url);

        //execute query
        $stmt->execute();


        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->setIdUrl($row['id_url']);
        $this->setLibelle($row['Libelle']);

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