<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'vendor/autoload.php';
ini_set('opcache.enable', '0');
use GraphAware\Neo4j\Client\ClientBuilder;



if ($_POST){
	$client = ClientBuilder::create()
	->addConnection('default', 'http://neo4j:neo4j@localhost:7474') // Example for HTTP connection configuration (port is optional)
	->build();

	$parameters = [
	    'person_id' => (int) $_POST['person_id']
	];
	$query = 'MATCH (n:Person)-[:JOINED]->(e:Event{event_type:"hiking"})<-[:JOINED]-(z:Person)<-[:FRIEND]-(o) 
	WHERE ID(n) = {person_id}
	RETURN o.name as name';
	$result = $client->run($query,$parameters);
	foreach ($result->getRecords() as $record) {
		echo $record->value('name');
		echo '<br>';
	}

}

//this part, show all the person and event information , and create a drop down menu
	$client = ClientBuilder::create()
	->addConnection('default', 'http://neo4j:neo4j@localhost:7474')
	->build();

	$query = 'MATCH (n:Person) RETURN n.name as name, ID(n) as id';
	$result = $client->run($query);?>
	<form action="whomayalsolike.php" method="POST">
	Do you like hiking with this memeber?

	<?php $client = ClientBuilder::create()
	->addConnection('default', 'http://neo4j:neo4j@localhost:7474')
	->build();

	$query = 'MATCH (n:Person) RETURN n.name as name, ID(n) as id';
	$result = $client->run($query);?>
	Your name:
	<select name="person_id">
		<?php foreach ($result->getRecords() as $record) {?>
			<option value="<?php echo $record->value('id');?>"><?php echo $record->value('name');?></option>
		<?php }?>
	</select>
	<br>
	<input type="submit">
	</form>
