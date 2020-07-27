<?php
$content = file_get_contents('http://pokedex.jlb.ninja/wp-json/wp/v2/posts');

$articles = json_decode($content);

echo '<div style="border: solid 2px #F00">';
    echo '<div style="; background-color:#CCC">@'.__FILE__.' : '.__LINE__.'</div>';
    echo '<pre>';
    print_r($articles);
    echo '</pre>';
echo '</div>';


echo '<article>';
foreach($articles as $article) {
    echo '<h1>' . $article->title->rendered . '</h1>';
}
echo '</article>';