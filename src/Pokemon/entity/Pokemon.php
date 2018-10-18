<?php

class pokemon
{
    protected $id;

    protected $nom;

    protected $type1;

    protected $type2;

    protected $image;

    public function __construct($id, $nom, $type1, $type2, $image)
    {
        $this->id = $id;
        $this->type1 = $type1;
        $this->type2 = $type2;
        $this->nom = $nom;
        $this->image = $image;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getType2()
    {
        return $this->type2;
    }

    public function setType2($type2)
    {
        $this->type2 = $type2;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function toArray()
    {
        $array = array();
        $array['id'] = $this->id;
        $array['nom'] = $this->nom;
        $array['type1'] = $this->type1;
        $array['type2'] = $this->type2;
        $array['image'] = $this->image;


        return $array;
    }
}
