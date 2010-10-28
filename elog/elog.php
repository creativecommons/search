<?php
// via http://nevyan.blogspot.com/2006/12/free-website-click-heatmap-diy.html

function save_file($filename) {
	$message = date("Y-m-d H:i:s") . "," . $_GET["id"] . "," . $_GET["event"];

	if ($message != ""){
		$message = "\n" . $message;
		$fp = fopen($filename, "a") or die("error opening");
		$write = fputs($fp, $message);
		fclose($fp);
	}
}

save_file("/home/alex/elog2.txt");
?>
