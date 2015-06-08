<?php

$q = $_GET['q'];
$u = $_GET['url'];

$fp = fopen('queries.txt', 'a');
fwrite($fp, $q);
fwrite($fp, $u);
fclose($fp);

$u = urldecode($u);

header('Location: ' . $u);

?>