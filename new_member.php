<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use GraphAware\Neo4j\Client\ClientBuilder;


if ($_POST){
	$client = ClientBuilder::create()
	->addConnection('default', 'http://neo4j:neo4j@localhost:7474') // Example for HTTP connection configuration (port is optional)
	->build();

	$client->run('CREATE (n:Person) SET n += {infos}', ['infos' => ['name' => $_POST['name'], 'age' => $_POST['age'], 
	'gender' => $_POST['gender'], 'telephone' => $_POST['telephone']]]);

	//$client->run('CREATE (n:Person) SET n += {infos}', ['infos' => $_POST]);
}

//$records = $result->getRecords();
//print_R($records);


?>

<form method="POST" action="new_member.php">
name: <input  type="text" name="name">
<br>
telphone:<input type="text" name="telephone"><br>
gender:<input type="text" name="gender" placeholder="M/F"><br>
age:<input type="text" name="age"><br>
submit:<input type="submit">
</form>
