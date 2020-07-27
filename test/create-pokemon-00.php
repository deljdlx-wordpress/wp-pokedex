<?php

require __DIR__.'/../source/class/WordpressAPI.php';


$client = new WordpressAPI(
    'http://pokedex.jlb.ninja/wp-json/wp/v2',
    'chatvert',
    'TKr2 5EGF eYnr Xkhq 3cPV YN2u'
);


$path = __DIR__ . '/../data/species';

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

        $content = null;
        foreach($data->flavor_text_entries as $index => $value) {
            if($value->language->name == 'fr') {
                $content = $value->flavor_text;
                break;
            }
        }


        $medias = $client->searchMedia($data->id.'-'.$data->name);
        $imageId = null;
        if(count($medias)) {
            $imageId = $medias[0]->id;
        }



        
        $response = $client->createPost($name, $content, $imageId);

        echo "\n===========================\n";
        print_r($data->id.'-'.$data->name . "\t" . $imageId);        
        echo "\n";

        print_r($response);
        echo "\n";
        echo "\n===========================\n";
        //echo __FILE__.':'.__LINE__; exit();
    }
}

