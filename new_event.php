<?php

require_once 'vendor/autoload.php';

use GraphAware\Neo4j\Client\ClientBuilder;


if ($_POST){
	$client = ClientBuilder::create()
	->addConnection('default', 'http://neo4j:neo4j@localhost:7474') // Example for HTTP connection configuration (port is optional)
	->build();

	// $client->run('CREATE (n:Event) SET n += {infos}', ['infos' => ['name' => $_POST['name'], 'age' => $_POST['age'], 
	// 'gender' => $_POST['gender'], 'telephone' => $_POST['telephone']]]);

	$client->run('CREATE (n:Event) SET n += {infos}', ['infos' => $_POST]);
}

//$records = $result->getRecords();
//print_R($records);


?>

<form method="POST" action="new_event.php">
Event name: <input  type="text" name="name">
<br>
Event type:  <select name="event_type">
<option value="hiking">Hiking</option>
<option value="Swimming">Swimming</option>
<option value="Dinner">Dinner Meeting</option>
<option value="Lunch">Lunch Meeting</option>
<option value="BBQ">BBQ</option>
</select>
<br>
Date:<input type="date" name="date"><br>
Location:<input type="text" name="location"><br>
submit:<input type="submit">
</form>
