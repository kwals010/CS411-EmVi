<?php
include 'vendor/autoload.php';
include 'CDN.php';

parse_str(implode('&', array_slice($argv, 1)), $_GET);

if ($_GET['url'] != null) {
	echo UploadContent($_GET['url']);
	}
else if ($_GET['content'] != null) {
	echo DeleteContent($_GET['content']);
	}

	//echo UploadContent($contentPath);
?>