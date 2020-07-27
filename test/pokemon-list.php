<?php

require __DIR__. '/../source/class/PokeAPI.php';

$test = new PokeAPI();

$pokemons = $test->getPokemons();



//foreach($pokemons)
//print_r(count($pokemons));