<?php
require 'vendor/autoload.php';

include './config/Database.php';
include './models/Pokemon.php';
include './models/Type.php';
include './models/Url.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);


$app->get('/pokemon', function ($request,$response) {


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

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $pokemon_item = array(
                'id' => $id_pokemon,
                'nom' => $nom,
                'url' => 'http://' . $_SERVER['SERVER_NAME'] .  $_SERVER['REQUEST_URI'] . '/' . $id_pokemon,
            );

            array_push($pokemon_arr['data'], $pokemon_item);
        }

        return $response->withJson(array('status' => 'true', 'result' => $pokemon_arr), 200);
    } else{
        return $response->withJson(array('status' => 'Pokemon Not Found'),422);
    }

});

$app->get('/pokemon/{id}', function ($request,$response) {

    $id     = $request->getAttribute('id');
    //instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    $pokemon = new Pokemon($db);


    //get ID
    $pokemon->setId( $id);

    $pokemon->read_one();

    $pokemon_arr = array(
        'id_pokemon' => $pokemon->getId(),
        'nom' => $pokemon->getNom(),
        'type_1' => $pokemon->getType1(),
        'type_2' => $pokemon->getType2(),
        'id_image' => $pokemon->getImage()
    );

    if($pokemon_arr['id_pokemon']!== null){
        //convert to json
        return $response->withJson(array('status' => 'true','result'=> $pokemon_arr),200);
    } else {
        return $response->withJson(array('status' => 'Pokemon Not Found'), 422);
    }


});

$app->run();