<?php
require 'vendor/autoload.php';
use OpenCloud\Rackspace;


// INITIATE CDN SESSION
// Establishes and authenticates CDN connection
// $authURL, $username, $apiKey, $dataCenterLocation currently hardwired
// Can be moved to database settings on configuration page
// RETURNS: Authenticated connection to CDN
function InitCDNSession()
{	
	//AUTHENTICATION URL
	$authURL = 'https://identity.api.rackspacecloud.com/v2.0/';

	//AUTHENTICATION CREDENTIALS
	$credentials = array(
	    'username' => 'ubno1250',
	    'apiKey' => '08a64cac4a0f12c9d7d5f6da2042ef2a'
	);

	//CLIENT CONNECTION OBJECT
	$client = new Rackspace(RACKSPACE_US, $credentials);

	//CDN FILE CLOUD SERVICE INSTANCE
	$service = $client->objectStoreService('cloudFiles', 'IAD');
	
	return $service;
}


// CREATE STORAGE CONTAINER ON CDN
// Defaults to creating emvi container
// Can be used to create additional containers for organizing content
// Makes container publically viewable on creation
// PREREQUISITE: Container must not exist
function CreateContainer($containerName = 'emvi')
{
	$service = InitCDNSession();
	
	$container = $service->createContainer($containerName);
	$container->enableCdn();
}

	
// DELETE STORAGE CONTAINER ON CDN
// Defaults to deleting emvi container
// PREREQUISITE: Container must exist
function DeleteContainer($containerName = 'emvi')
{
	$service = InitCDNSession();
	
	$container = $service->getContainer($containerName);
	$container->disableCdn();
	$container->deleteAllObjects();
	$container->delete();
}


//UPLOAD CONTENT
// $contentPath: File location on local server
// $contentName: CDN names defaults to original filename if name not specified
// $containerName: Defaults to emvi container
// RETURNS: publically accesible URL of uploaded content 
// PREREQUISITE: Container must exist
function UploadContent($contentPath, $contentName = NULL, $containerName = 'emvi')
{	
	$service = InitCDNSession();
	$container = $service->getContainer($containerName);

	if ($contentName == NULL)
		$contentName = basename($contentPath);
	
	$contentType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $contentPath);

	$data = fopen($contentPath, 'r');	
	$container->uploadObject($contentName, $data, 
							 array ('content-type'=>$contentType));
							
	return GetContentURL($contentName);
}


// DELETE CONTENT
// $contentName: name of file on CDN to delete
// $containerName: Defaults to emvi container
// PREREQUISITE: Container must exist, file must exist on CDN
function DeleteContent($contentName, $containerName = 'emvi')
{
	$service = InitCDNSession();
	
	$container = $service->getContainer($containerName);
	$file = $container->getObject($contentName);
	$file->delete();
}


// GET CONTENT URL
// $contentName: name of file on CDN
// $containerName: Defaults to searching emvi container
// RETURNS: publically accesible URL of uploaded content 
// PREREQUISITE: Container must exist, file must exist on CDN
function GetContentURL($contentName, $containerName = 'emvi')
{
	$service = InitCDNSession();
	
	$container = $service->getContainer($containerName);
	$file = $container->getObject($contentName);
	
	$publicURL = $file->getPublicUrl();
	
	return $publicURL;
}
	
	
// GET CONTAINER URL
// Supposed to return public URL of container. Seems to be broken in SDK
// ************************
// function GetBaseURL($containerName = 'emvi')
// {	
// 	$service = InitCDNSession();
// 	
// 	$container = $service->getContainer($containerName);
// 	$publicURL = $container->getPublicUrl();
// 	
// 	return $publicURL;
// }
	
?>