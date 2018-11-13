<?php
/**
 * Created by PhpStorm.
 * User: romi
 * Date: 01/11/2018
 * Time: 17:06
 */


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Pokemon.php';

//instantiate DB & connect
$database = new Database();
$db = $database->connect();

$pokemon = new Pokemon($db);

//get ID
$pokemon->setId( isset($_GET['id_pokemon']) ? $_GET['id_pokemon'] : die());

$pokemon->read_one();

$pokemon_arr = array(
    'id_pokemon' => $pokemon->getId(),
    'nom' => $pokemon->getNom(),
    'type_1' => $pokemon->getType1(),
    'type_2' => $pokemon->getType2(),
    'lien_image' => $pokemon->getImage()
    );
if($pokemon_arr['id_pokemon']!== null){
    //convert to json
    echo(json_encode($pokemon_arr));
} else {
    echo json_encode(
        array("message" => 'no pokemon found')
    );
}



