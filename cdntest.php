<?php
require 'vendor/autoload.php';


use OpenCloud\Rackspace;
echo "test";
$client = new Rackspace(Rackspace::US_IDENTITY_ENDPOINT, array(
    'username' => 'ubno1250',
    'apiKey'   => '08a64cac4a0f12c9d7d5f6da2042ef2a'
));

echo "test";
?>