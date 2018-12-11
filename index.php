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


$app->get('/pokemon', function ($request, $response) {


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

        return $response->withJson(array('status' => 'true', 'result' => $pokemon_arr), 200);
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
        'id_image' => $pokemon->getImage(),
        'url_image' => 'http://' . $_SERVER['SERVER_NAME'] . ':8050' . "/Pokecardss/url" . '/' . $pokemon->getImage()
    );

    if ($pokemon_arr['id_pokemon'] !== null) {
        //convert to json
        return $response->withJson(array('status' => 'true', 'result' => $pokemon_arr), 200);
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


    $url->read_one($id);


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


$app->post('/pokemon', function($request,$response){

    $data = $request->getParsedBody();

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
});

$app->run();