<?php
/**
 * Created by PhpStorm.
 * User: lance
 * Date: 15/10/2018
 * Time: 19:53
 */

$url='http://www.ray0.be/pokeapi';
$url_img="/pokemon-img/fr/";
$url_row="/pokemon-row/fr/";



function getNomPokemonById($id = 1) {

    global $url,$url_row;

    $url_json = file_get_contents($url.$url_row.$id);
    $id_array = json_decode($url_json,true);

    $nom_pokemon = $id_array["data"]["nom_fr"];

    return $nom_pokemon;
}

function getIdPokemonByNom($nom = "pikachu") {

    global $url,$url_row;

    $url_json = file_get_contents($url.$url_row.$nom);
    $nom_array = json_decode($url_json,true);

    $id_pokemon = $nom_array["data"]["id"];

    return $id_pokemon;
}

function getTypesPokemonById($id = 1) {

    global $url,$url_row;

    $url_json = file_get_contents($url.$url_row.$id);
    $id_array = json_decode($url_json,true);

    $type_pokemon_1 = $id_array["data"]["type1"];
    $type_pokemon_2 = $id_array["data"]["type2"];

    return array($type_pokemon_1,$type_pokemon_2);


}

function getTypesPokemonByNom($nom = "pikachu") {

    global $url,$url_row;

    $url_json = file_get_contents($url.$url_row.$nom);
    $nom_array = json_decode($url_json,true);

    $type_pokemon_1 = $nom_array["data"]["type1"];
    $type_pokemon_2 = $nom_array["data"]["type2"];

    return array($type_pokemon_1,$type_pokemon_2);
}

function getImgPokemon($nom = "pikachu") {

    global $url,$url_row;

    $url_json = file_get_contents($url.$url_row.$nom);
    $nom_array = json_decode($url_json,true);

    $img64 = $nom_array["data"]["image64"];

    return $img64;
}


