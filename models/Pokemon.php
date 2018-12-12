<?php
/**
 * Created by PhpStorm.
 * User: romi
 * Date: 01/11/2018
 * Time: 15:22
 */

class Pokemon {


    private $conn;
    private $id_pokemon;
    private $nom;
    private $id_type1;
    private $id_type2;
    private $id_image;


    //Constuctor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get all pokemon
    public function read() {
        //create query
        $query = 'Select * from pokemon';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    //Get 1 pokemon
    public function read_one() {
        //create query
        $query = 'Select * from pokemon where id_pokemon = ? LIMIT 0,1';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //BIND id
        $stmt->bindParam(1, $this->id_pokemon);

        //execute query
        $stmt->execute();


        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->setId($row['id_pokemon']);
        $this->setNom($row['nom']);
        $this->setType1($row['id_type1']);
        $this->setType2($row['id_type2']);
        $this->setImage($row['id_image']);


        return $stmt;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id_pokemon;
    }

    /**
     * @param mixed $id_pokemon
     */
    public function setId($id_pokemon)
    {
        $this->id_pokemon = $id_pokemon;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getType1()
    {
        return $this->id_type1;
    }

    /**
     * @param mixed $type1
     */
    public function setType1($type1)
    {
        $this->id_type1 = $type1;
    }

    /**
     * @return mixed
     */
    public function getType2()
    {
        return $this->id_type2;
    }

    /**
     * @param mixed $type2
     */
    public function setType2($type2)
    {
        $this->id_type2 = $type2;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->id_image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->id_image = $image;
    }





}