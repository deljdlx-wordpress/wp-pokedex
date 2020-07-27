<?php

require __DIR__.'/../source/class/WordpressAPI.php';

require __DIR__.'/../source/class/PokeAPI.php';


$client = new WordpressAPI(
    'http://pokedex.jlb.ninja/wp-json/wp/v2',
    'chatvert',
    'TKr2 5EGF eYnr Xkhq 3cPV YN2u'
);


//$pokeApi = new PokeAPI();

$path = __DIR__ . '/../data/pokemon';

$dir = opendir($path);

while($f = readdir($dir)) {
    if($f != '.' && $f != '..') {

        $data = json_decode(file_get_contents($path . '/' . $f));

        $speciesData = json_decode(file_get_contents($data->species->url));
        $pokemonName = null;
        foreach($speciesData->names as $index => $value) {
            if($value->language->name == 'fr') {
                $pokemonName = $value->name;
                break;
            }
        }

        if($pokemonName) {
            $post = $client->searchPost($pokemonName)[0];
            if($post) {
                $categoriesId = [];
                $types = [];

                foreach($data->types as $index => $typeData) {
                    $type = json_decode(file_get_contents($typeData->type->url));
        
                    $typeName = null;

                    foreach($type->names as $value) {
                        if($value->language->name == 'fr') {
                            $typeName = $value->name;
                            break;
                        }
                    }
        
                    $types[]= $typeName;

                    $category = $client->searchCategory($type->id.'-'.$typeName)[0];
                    if($category) {
                        $categoriesId[] = $category->id;
                    }
                }
                if(!empty($categoriesId))  {
                    $response = $client->updatePostCategories($post->id, $categoriesId);
                    echo "\n=================================\n";
                    echo $pokemonName . "\t" . implode("\t", $types) . PHP_EOL;
                    print_r(json_decode($response));
                    echo "\n=================================\n";
                }

            }
        }


    }
}

