<?php
/**
 * Created by PhpStorm.
 * User: romi
 * Date: 01/11/2018
 * Time: 17:51
 */

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-with');



include_once '../../config/Database.php';
include_once '../../models/Pokemon.php';

//instantiate DB & connect
$database = new Database();
$db = $database->connect();

$pokemon = new Pokemon($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$pokemon->setId($data->id_pokemon);
$pokemon->setNom($data->nom);
$pokemon->setType1($data->id_type1);
if(isset($data->id_type2)){
    $pokemon->setType2($data->id_type2);
}

$pokemon->setImage($data->id_image);

//Create pokemon
if($pokemon->create()){
    echo json_encode(
        array('message' => 'Pokemon created')
    );
} else {
    echo json_encode(
        array('message' => 'Pokemon not created')
    );
}