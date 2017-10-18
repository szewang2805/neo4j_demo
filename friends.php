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

	$tx = $client->transaction();
	$stack = $client->stack();


	foreach ($_POST['like_person_id'] as $each_id){
		$query = 'MATCH (s:Person)
		WHERE ID(s) = {person_id}
		MATCH (n:Person)
		WHERE ID(n) = {event_id}
		CREATE (n)-[:FRIEND]->(s)
		RETURN n';

		$parameters = [
		    'person_id' => (int) $_POST['person_id'],
		    'event_id' => (int) $each_id,
		];
      $stack->push($query, $parameters);
	}

	  $tx->runStack($stack);
	  $results = $tx->commit();
      echo 'Added record!';


}

//this part, show all the person and event information , and create a drop down menu
	$client = ClientBuilder::create()
	->addConnection('default', 'http://neo4j:neo4j@localhost:7474')
	->build();

	$query = 'MATCH (n:Person) RETURN n.name as name, ID(n) as id';
	$result = $client->run($query);?>
	<form action="friends.php" method="POST">
	Do you like...
	<br>
	<?php foreach ($result->getRecords() as $record) {?>
	<input name="like_person_id[]" type="checkbox" value="<?php echo $record->value('id');?>"><?php echo $record->value('name');?><br>
	<?php }?>
	<br>

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
