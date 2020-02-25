<?php require_once '../../../private/initialize.php'; ?>

<?php

$albums = Album::find_by_field_and_sort('artist_id', '10', 'year');

var_dump($albums);

?>

<h1>Show Almums</h1>