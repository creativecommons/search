<?php

$q = $_GET['q'];
$u = $_GET['url'];

$fp = fopen('queries.txt', 'a');
fwrite($fp, $q . PHP_EOL);
fwrite($fp, $u . PHP_EOL);
fclose($fp);

$u = urldecode($u);

header('Location: ' . $u);

?>