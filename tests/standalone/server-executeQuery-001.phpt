--TEST--
MongoDB\Server::executeQuery() with filter and projection
--SKIPIF--
<?php require "tests/utils/basic-skipif.inc" ?>
--FILE--
<?php
require_once "tests/utils/basic.inc";

$parsed = parse_url(MONGODB_URI);
$server = new MongoDB\Server($parsed["host"], $parsed["port"]);

// load fixtures for test
$batch = new \MongoDB\WriteBatch();
$batch->insert(array('_id' => 1, 'x' => 2, 'y' => 3));
$batch->insert(array('_id' => 2, 'x' => 3, 'y' => 4));
$batch->insert(array('_id' => 3, 'x' => 4, 'y' => 5));
$server->executeWriteBatch(NS, $batch);

$query = new MongoDB\Query(array('x' => 3), array('projection' => array('y' => 1)));
$cursor = $server->executeQuery(NS, $query);

var_dump($cursor instanceof MongoDB\QueryResult);
var_dump($server == $cursor->getServer());
var_dump(iterator_to_array($cursor));

?>
===DONE===
<?php exit(0); ?>
--EXPECT--
bool(true)
bool(true)
array(1) {
  [0]=>
  array(2) {
    ["_id"]=>
    int(2)
    ["y"]=>
    int(4)
  }
}
===DONE===
