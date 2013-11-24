
<?php
require 'vendor/autoload.php';
require 'CDN.php';

$testCase = '5';
$contentPath = 'images/test.jpg';
$contentName = basename($contentPath);

switch($testCase){
	case '1':
	//CREATE CONTAINER
	//DEFAULT CONTAINER NAME = 'emvi'
	CreateContainer();
	echo "Container Created";
	break;

	case '2':
	//DELETE CONTAINER
	//DEFAULT CONTAINER NAME = 'emvi'
	DeleteContainer();
	echo "Container Deleted";
	break;

	case '3':
	//UPLOAD CONTENT
	//FILENAME EXTRACTED FROM PATH, DEFAULT CONTAINER NAME = 'emvi'
	echo "UPLOAD URL:" . UploadContent($contentPath, 'test4.jpg');
	break;

	case '4':
	//DELETE CONTENT
	//DEFAULT CONTAINER NAME = 'emvi'
	DeleteContent($contentName);
	echo "CONTENT DELETED";
	break;

	case '5':
	//GET CONTENT URL
	//DEFAULT CONTAINER NAME = 'emvi'
	echo "CONTENT URL:" .  GetContentURL($contentName);
	break;
}

?>
