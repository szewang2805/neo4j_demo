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

	// $client->run('CREATE (n:Event) SET n += {infos}', ['infos' => ['name' => $_POST['name'], 'age' => $_POST['age'], 
	// 'gender' => $_POST['gender'], 'telephone' => $_POST['telephone']]]);

        $query = 'MATCH (s:Person)
        WHERE ID(s) = {person_id}
        MATCH (n:Event)
        WHERE ID(n) = {event_id}
		CREATE (n)<-[:JOINED {is_:0}]-(s)
		RETURN n';

        $parameters = [
            'person_id' => (int) $_POST['person_id'],
            'event_id' => (int) $_POST['event_id'],
        ];

      $client->run($query, $parameters);
      echo 'Added record!';
}


//this part, show all the person and event information , and create a drop down menu
	$client = ClientBuilder::create()
	->addConnection('default', 'http://neo4j:neo4j@localhost:7474')
	->build();

	$query = 'MATCH (n:Event) RETURN n.name as name, ID(n) as id';
	$result = $client->run($query);?>
	<form action="join.php" method="POST">
	Join which event:
	<select name="event_id">
		<?php foreach ($result->getRecords() as $record) {?>
			<option value="<?php echo $record->value('id');?>"><?php echo $record->value('name');?></option>
		<?php }?>
	</select>
<br>

	<?php $client = ClientBuilder::create()
	->addConnection('default', 'http://neo4j:neo4j@localhost:7474')
	->build();

	$query = 'MATCH (n:Person) RETURN n.name as name, ID(n) as id';
	$result = $client->run($query);?>
	Who will join event:
	<select name="person_id">
		<?php foreach ($result->getRecords() as $record) {?>
			<option value="<?php echo $record->value('id');?>"><?php echo $record->value('name');?></option>
		<?php }?>
	</select>
	<br>
	<input type="submit">
	</form>
