<?php

require __DIR__.'/../source/class/WordpressAPI.php';


$client = new WordpressAPI(
    'http://pokedex.jlb.ninja/wp-json/wp/v2',
    'chatvert',
    'TKr2 5EGF eYnr Xkhq 3cPV YN2u'
);


$path = __DIR__ . '/../image/artwork';

$dir = opendir($path);

while($f = readdir($dir)) {
    if($f != '.' && $f != '..') {
        echo $f.PHP_EOL;
        $response = $client->uploadImage($path . '/' . $f, $f);

        echo "\n===========================\n";
        echo $f . "\n";
        print_r($response);
        echo "\n===========================\n";
    }
}




/*
$file = file_get_contents( __DIR__ . '/../image/artwork/1-bulbasaur.jpg' );
$url = 'http://pokedex.jlb.ninja/wp-json/wp/v2/media/';
$ch = curl_init();
$username = 'chatvert';
$password = '514ever';

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $file );
curl_setopt( $ch, CURLOPT_HTTPHEADER, [
	'Content-Disposition: form-data; filename="example.jpg"',
	'Authorization: Basic ' . base64_encode( $username . ':' . $password ),
] );
$result = curl_exec( $ch );
curl_close( $ch );
print_r( json_decode( $result ) );
echo "\n\n";
*/

