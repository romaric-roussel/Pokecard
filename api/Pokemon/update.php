<?php
/**
 * Created by PhpStorm.
 * User: romi
 * Date: 02/11/2018
 * Time: 14:26
 */
//TODO update un seul champ
//TODO message d'erreur si l'id n'existe pas.

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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


//Update pokemon
if($pokemon->update()){
    echo json_encode(
        array('message' => 'Pokemon updated')
    );
} else {
    echo json_encode(
        array('message' => 'Pokemon not updated')
    );
}