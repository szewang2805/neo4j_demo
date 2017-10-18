<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use GraphAware\Neo4j\Client\ClientBuilder;

$client = ClientBuilder::create()
    ->addConnection('default', 'http://neo4j:neo4j@localhost:7474') // Example for HTTP connection configuration (port is optional)
    ->build();

$result = $client->run('MATCH (n:Person) RETURN n');
// a result always contains a collection (array) of Record objects

// get all records
$records = $result->getRecords();
//print_R($records);


?>

<form>
name: <input type="text" name="name">
<br>
telphone:<input type="text" name="telephone"><br>
gender:<input type="text" name="gender" placeholder="M/F"><br>
age:<input type="text" name="age"><br>
submit:<input type="submit">
</form>
