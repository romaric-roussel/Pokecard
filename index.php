<?php
require 'vendor/autoload.php';

include './config/Database.php';
include './models/Pokemon.php';
include './models/Type.php';
include './models/Url.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-with');

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
    $num = $result->rowCount();

    //check if any pokemon
    if ($num > 0) {

        $pokemon_arr = array();
        $pokemon_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $pokemon_item = array(
                'id' => $id_pokemon,
                'nom' => $nom,
                'url' => 'http://' . $_SERVER['SERVER_NAME'] . ':8050' . $_SERVER['REQUEST_URI'] . '/' . $id_pokemon,

            );

            array_push($pokemon_arr['data'], $pokemon_item);
        }

        return $response->withJson(array('status' => 'true','count' => count($pokemon_arr['data']), 'result' => $pokemon_arr), 200);
    } else {
        return $response->withJson(array('status' => 'Pokemon Not Found'), 422);
    }


});


$app->get('/pokemon/{id}', function ($request, $response) {

    $id = $request->getAttribute('id');
    //instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    $pokemon = new Pokemon($db);


    //get ID
    $pokemon->setId($id);

    $pokemon->read_one();

    $pokemon_arr = array(
        'id_pokemon' => $pokemon->getId(),
        'nom' => $pokemon->getNom(),
        'type_1' => $pokemon->getType1(),
        'type_2' => $pokemon->getType2(),
        'id_image' => $pokemon->getImage()
    );

    if ($pokemon_arr['id_pokemon'] !== null) {
        //convert to json
        return $response->withJson(array('status' => 'true', 'result' => $pokemon_arr,
            'url_image' => 'http://' . $_SERVER['SERVER_NAME'] . ':8050' . "/Pokecardss/url" . '/' . $pokemon->getImage(),
            'url_type1' => 'http://' . $_SERVER['SERVER_NAME'] . ':8050/Pokecardss/type/'.$pokemon->getType1(),
            'url_type2' => 'http://' . $_SERVER['SERVER_NAME'] . ':8050/Pokecardss/type/'.$pokemon->getType2()),200);
    } else {
        return $response->withJson(array('status' => 'Pokemon Not Found'), 422);
    }


});


$app->get('/url/{id}', function ($request, $response) {

    $id = $request->getAttribute('id');
    //instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    $url = new Url($db);
    //get ID
    $url->setIdUrl($id);
    $url->read_one();


    $url_arr = array(
        'id_url' => $url->getIdUrl(),
        'libelle' => $url->getLibelle(),

    );

    if ($url_arr['id_url'] !== null) {
        //convert to json
        return $response->withJson(array('status' => 'true', 'result' => $url_arr), 200);
    } else {
        return $response->withJson(array('status' => 'url Not Found'), 422);

    }


});

$app->get('/type', function ($request,$response) {


    //instantiate DB & connect
    $database = new Database();
    $db = $database->connect();


    $type = new Type($db);
    $result = $type->read();
    //get row count
    $num = $result->rowCount();

    //check if any pokemon
    if ($num > 0) {

        $type_arr = array();
        $type_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $type_item = array(
                'id_type' => $id_type,
                'nom' => $libelle,
                'url' => 'http://' . $_SERVER['SERVER_NAME'] . ':8050' . $_SERVER['REQUEST_URI'] . '/' . $id_type,

            );

            array_push($type_arr['data'], $type_item);
        }

        return $response->withJson(array('status' => 'true','count' => count($type_arr['data']), 'result' => $type_arr), 200);
    } else {
        return $response->withJson(array('status' => 'Pokemon Not Found'), 422);
    }


});

$app->get('/type/{id}', function ($request, $response) {

    $id = $request->getAttribute('id');
    //instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    $type = new Type($db);
    //get ID
    $type->setIdType($id);
    $type->read_one();


    $type_arr = array(
        'id_type' => $type->getIdType(),
        'libelle' => $type->getLibelle(),

    );

    if ($type_arr['id_type'] !== null) {
        //convert to json
        return $response->withJson(array('status' => 'true', 'result' => $type_arr,'url' => 'http://' . $_SERVER['SERVER_NAME'] . ':8050/Pokecardss/type'), 200);
    } else {
        return $response->withJson(array('status' => 'url Not Found'), 422);

    }


});




$app->run();