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
    private $nom_type1;
    private $nom_type2;
    private $libelleUrl;


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
        $query = 'Select pokemon.id_pokemon,pokemon.nom,pokemon.id_type1,pokemon.id_type2,pokemon.id_image,type1.libelle as type1,type2.libelle as type2,url.Libelle from pokemon left JOIN url on pokemon.id_image = url.id_url left JOIN type type1 on pokemon.id_type1 = type1.id_type left JOIN type type2 on pokemon.id_type2 = type2.id_type where pokemon.id_pokemon =  ? LIMIT 0,1';

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
        $this->setNomType1($row['type1']);
        $this->setNomType2($row['type2']);
        $this->setLibelleUrl($row['Libelle']);


        return $stmt;
    }

    //create pokemon
    public function create() {
        //create query
        $query = 'INSERT INTO  pokemon (id_pokemon,nom,id_type1,id_type2,id_image) VALUES (:id,:nom,:type_1,:type_2,:image)';
        //prepare statement
        $stmt = $this->conn->prepare($query);

        //BIND data
        $stmt->bindParam(':id', $this->id_pokemon);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':type_1', $this->id_type1);
        $stmt->bindParam(':type_2', $this->id_type2);
        $stmt->bindParam(':image', $this->id_image);

        //execute query
        if($stmt->execute()){
            return true;
        }

        printf("Error : %s.\n",$stmt->error);

        return false;
    }

    //Update pokemon
    public function update() {
        //create query
        $query = "UPDATE pokemon SET nom = :nom, id_type1 = :id_type1, id_type2 = :id_type2,id_image = :id_image where id_pokemon = :id_pokemon";
        //prepare statement
        $stmt = $this->conn->prepare($query);

        //BIND data
        $stmt->bindParam(':id_pokemon', $this->id_pokemon);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':id_type1', $this->id_type1);
        $stmt->bindParam(':id_type2', $this->id_type2);
        $stmt->bindParam(':id_image', $this->id_image);


        //execute query
        if($stmt->execute()){
            echo $this->nom . " " . $this->id_type1 . " " . $this->id_type2 . " ". $this->id_image ;

            return true;
        }

        printf("Error : %s.\n",$stmt->error);

        return false;
    }

    //Delete pokemon
    public function delete() {
        $query = 'DELETE FROM ' .$this->table .' WHERE id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //BIND data
        $stmt->bindParam(':id', $this->id);

        //execute query
        if($stmt->execute()){
            return true;
        }

        printf("Error : %s.\n",$stmt->error);

        return false;
    }/**
 * @return mixed
 */
public function getNomType1()
{
    return $this->nom_type1;
}/**
 * @param mixed $nom_type1
 */
public function setNomType1($nom_type1)
{
    $this->nom_type1 = $nom_type1;
}/**
 * @return mixed
 */
public function getNomType2()
{
    return $this->nom_type2;
}/**
 * @param mixed $nom_type2
 */
public function setNomType2($nom_type2)
{
    $this->nom_type2 = $nom_type2;
}/**
 * @return mixed
 */
public function getLibelleUrl()
{
    return $this->libelleUrl;
}/**
 * @param mixed $libelleUrl
 */
public function setLibelleUrl($libelleUrl)
{
    $this->libelleUrl = $libelleUrl;
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