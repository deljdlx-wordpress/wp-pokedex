<?php

require __DIR__.'/../source/class/WordpressAPI.php';


$client = new WordpressAPI(
    'http://pokedex.jlb.ninja/wp-json/wp/v2',
    'chatvert',
    'TKr2 5EGF eYnr Xkhq 3cPV YN2u'
);


$path = __DIR__ . '/../data/type';

$dir = opendir($path);

while($f = readdir($dir)) {
    if($f != '.' && $f != '..') {

        $data = json_decode(file_get_contents($path . '/' . $f));

        $name = null;
        foreach($data->names as $index => $value) {
            if($value->language->name == 'fr') {
                $name = $value->name;
                break;
            }
        }

        if($name) {
            $response = $client->createCategory($name, '', $data->id . '-' . $client->slugify($name));
        }
        
        echo "\n===========================\n";
        echo $name . "\n";
        print_r($response);
        echo "\n===========================\n";
    }
}

