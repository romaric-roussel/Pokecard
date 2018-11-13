<?php
/**
 * Created by PhpStorm.
 * User: lpiem
 * Date: 06/11/2018
 * Time: 13:20
 */

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-with');


$url='http://www.ray0.be/pokeapi';
$url_img="/pokemon-img/fr/";
$url_row="/pokemon-row/fr/";

include_once '../../config/Database.php';
include_once '../../models/Pokemon.php';
include_once '../../models/Type.php';
include_once '../../models/url.php';

//instantiate DB & connection
$database = new Database();
$db = $database->connect();

$newPokemon = new Pokemon($db);
$newType = new Type($db);
$newUrl = new Url($db);



//get raw posted data
$dataUrl = json_decode(getImageApi());
//echo $dataUrl->data[0]->url_img;
$dataType = json_decode(getTypeApi());
$dataPokemon = json_decode(getDataApi());
//print_r($dataUrl);
//echo sizeof($dataUrl->data);






//Create Url
for($i = 0;$i<sizeof($dataUrl->data);$i++){
    $newUrl->setLibelle($dataUrl->data[$i]->url_img);
    if($newUrl->create()){
        echo json_encode(
            array('message' => 'url created')
        );
    } else {
        echo json_encode(
            array('message' => 'url not created')
        );
    }
}


//Create Type
for($i = 0;$i<sizeof($dataType);$i++){
    $newType->setIdType($dataType[$i]->id);
    $newType->setLibelle($dataType[$i]->type);
    if($newType->create()) {
        echo json_encode(
            array('message' => 'Type created')
        );
    } else {
        echo json_encode(
            array('message' => 'Type not created')
        );
    }
}

//Create pokemon
for($i = 0 ; $i<sizeof($dataPokemon->data);$i++){
    $newPokemon->setId($dataPokemon->data[$i]->id_pokemon);
    $newPokemon->setNom($dataPokemon->data[$i]->nom_pokemon);
    $newPokemon->setType1($dataPokemon->data[$i]->id_type1);
    $newPokemon->setType2($dataPokemon->data[$i]->id_type2);
    $newPokemon->setImage($dataPokemon->data[$i]->url_img);

    if($newPokemon->create()){
        echo json_encode(
            array('message' => 'Pokemon created')
        );
    } else {
        echo json_encode(
            array('message' => 'Pokemon not created')
        );
    }
}




function getDataApi() {
    global $url,$url_row,$url_img;
    $pokemon_arr = array();
    $pokemon_arr['data'] = array();
    for($i=1;$i<51;$i++){

        $url_json_row = file_get_contents($url.$url_row.$i);
        $result_array = json_decode($url_json_row,true);

        $id_pokemon = $result_array["data"]["id"];
        $nom_pokemon = $result_array["data"]["nom_fr"];
        $id_type1 = $result_array["data"]["type_1"];
        $id_type2 = $result_array["data"]["type_2"];
        $nom_type1 = $result_array["data"]["type1"];
        $nom_type2 = $result_array["data"]["type2"];
        $url_image = $id_pokemon;

        $pokemon_item = array(
            'id_pokemon' => $id_pokemon,
            'nom_pokemon' => $nom_pokemon,
            'id_type1' =>$id_type1,
            'id_type2' => $id_type2,
            'nom_type1' => $nom_type1,
            'nom_type2' => $nom_type2,
            'url_img' => $url_image
        );


        array_push($pokemon_arr['data'],$pokemon_item);


    }
    return json_encode($pokemon_arr);


}

function getTypeApi(){

    global $url,$url_row;
    $type = array();
    $type['type'] = array();
    $type2 = array();
    $type2['type2'] = array();

    for($i=1;$i<51;$i++){
        $url_json_row = file_get_contents($url.$url_row.$i);

        $result_array = json_decode($url_json_row,true);

        $id_type1 = $result_array["data"]["type_1"];
        $nom_type1 = $result_array["data"]["type1"];
        $id_type2 = $result_array["data"]["type_2"];
        $nom_type2 = $result_array["data"]["type2"];

        $type_item1 = array(

            'id_type' =>$id_type1,
            'nom_type' => $nom_type1,
        );
        $type_item2 = array(

            'id_type2' =>$id_type2,
            'nom_type2' => $nom_type2,
        );

        //array_push($type['type'],$type_item1);
        array_push($type['type'],$type_item1);
        //$type[$id_type1] = $nom_type1;
        array_push($type2['type2'],$type_item2);
        //$type2 = aru($type['type'], 'id_type');





    }

    $tab_type_merge = array_merge($type + $type2);
    $tab_type_unique = aru($tab_type_merge['type'],$tab_type_merge['type2'],'id_type','nom_type','id_type2','nom_type2');
    return json_encode($tab_type_unique);


}

function getImageApi() {
    global $url,$url_row,$url_img;
    $pokemon_arr = array();
    $pokemon_arr['data'] = array();
    for($i=1;$i<51;$i++){

        $url_json_row = file_get_contents($url.$url_row.$i);
        $result_array = json_decode($url_json_row,true);

        $id_pokemon = $result_array["data"]["id"];
        $nom_pokemon = $result_array["data"]["nom_fr"];
        $url_image = $url.$url_img.$nom_pokemon;

        $pokemon_item = array(
            'id_pokemon' => $id_pokemon,
            'url_img' => $url_image
        );

        array_push($pokemon_arr['data'],$pokemon_item);

    }
    return json_encode($pokemon_arr);

}

function aru( $ar ,$ar2 ,$critere1_array1, $critere2_array1, $critere1_array2, $critere2_array2){
    // création du tableau de sortie
    $out1 = array();
    // création du tableau contenant les références déjà rencontrées
    $interdits = array();
    for($i = 0;$i< sizeof($ar);$i++ ) {
        // si la valeur du champ de référence n'est pas dans le tableau d'interdiction
        if (isset($ar[$i][$critere1_array1])) {
            if (!in_array($ar[$i][$critere1_array1], $interdits)) {
                $out1[] = array('id' => $ar[$i][$critere1_array1], "type" => $ar[$i][$critere2_array1]);
                // et on ajoute la valeur du champ de référence au tableau d'interdiction
                $interdits[] = $ar[$i][$critere1_array1];
            }
        }
    }
    for($j = 0;$j<  sizeof($ar2);$j++ ) {
        // si la valeur du champ de référence n'est pas dans le tableau d'interdiction
        if (isset($ar2[$j][$critere1_array2])) {
            if (!in_array($ar2[$j][$critere1_array2], $interdits)) {
                $out1[] = array('id' => $ar2[$j][$critere1_array2], "type" => $ar2[$j][$critere2_array2]);
                // et on ajoute la valeur du champ de référence au tableau d'interdiction
                $interdits[] = $ar2[$j][$critere1_array2];
            }
        }
    }

    // dans le cas contraire, on ne fait rien, pas la peine de traiter

    return $out1;
}




