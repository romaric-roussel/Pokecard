<?php
/**
 * Created by PhpStorm.
 * User: romi
 * Date: 01/11/2018
 * Time: 16:33
 */

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Pokemon.php';

//instantiate DB & connect
$database = new Database();
$db = $database->connect();

$pokemon = new Pokemon($db);

$result = $pokemon->read();

//get row count
$num =$result->rowCount();

//check if any pokemon
if($num > 0) {

    $pokemon_arr = array();
    $pokemon_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $pokemon_item = array(
            'id' => $id_pokemon,
            'nom' => $nom,
            'type_1' =>$type_1,
            'type_2' => $type_2,
            'image' => $lien_image,

        );
        array_push($pokemon_arr['data'],$pokemon_item);
    }

    //convert to json
    echo json_encode($pokemon_arr);
} else {
    echo json_encode(
        array("message" => 'no pokemon found')
    );
}


