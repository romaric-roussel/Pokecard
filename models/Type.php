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

    //create type
    public function create() {
        //create query
        $query = 'INSERT INTO  type (id_type, libelle) VALUES (:id_type,:libelle)';
        //prepare statement
        $stmt = $this->conn->prepare($query);

        //BIND data
        //$stmt->bindParam(':id_type', $this->id_pokemon);
        $stmt->bindParam(':id_type', $this->id_type);
        $stmt->bindParam(':libelle', $this->libelle);


        //execute query
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e){
            print_r( $e->getMessage( ) , $e->getCode( ) );
            return false;
        }

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


