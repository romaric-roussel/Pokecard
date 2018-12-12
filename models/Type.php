<?php
/**
 * Created by PhpStorm.
 * User: romi
 * Date: 07/11/2018
 * Time: 00:05
 */

class Type
{
    private $conn;
    private $id_type;
    private $libelle;

    //Constuctor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }


    //Get all type
    public function read() {
        //create query
        $query = 'Select * from type';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    public function read_one() {
    //create query
    $query = 'Select * from type where id_type = ? LIMIT 0,1';

    //prepare statement
    $stmt = $this->conn->prepare($query);

    //BIND id
    $stmt->bindParam(1, $this->id_type);

    //execute query
    $stmt->execute();


    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //set properties
    $this->setIdType($row['id_type']);
    $this->setLibelle($row['libelle']);

    return $stmt;
}

    /**
     * @return mixed
     */
    public function getIdType()
    {
        return $this->id_type;
    }

    /**
     * @param mixed $id_type
     */
    public function setIdType($id_type)
    {
        $this->id_type = $id_type;
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


