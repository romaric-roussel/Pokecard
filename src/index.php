<?php
/**
 * Created by PhpStorm.
 * User: lpiem
 * Date: 15/10/2018
 * Time: 16:08
 */
header('Content-Type: application/json');

require __DIR__.'/Pokemon/controller/PokemonController.php';
require __DIR__.'/Pokemon/entity/Pokemon.php';


$pokemon = new pokemon(1,"bulbisar","plant","feu","");


$tagoleee =  getTypesPokemonById(94);
print_r($tagoleee);
echo getIdPokemonByNom("carapuce");
echo (getImgPokemon("1"));
print_r(getTypesPokemonByNom("pikachu"));
echo getNomPokemonById(1);
print_r($pokemon->toArray());




