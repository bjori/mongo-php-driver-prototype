--TEST--
MongoDB\Manager::executeDelete() one document
--SKIPIF--
<?php require "tests/utils/basic-skipif.inc" ?>
--FILE--
<?php
require_once "tests/utils/basic.inc";

$manager = new MongoDB\Manager(MONGODB_URI);

// load fixtures for test
$manager->executeInsert(NS, array('_id' => 1, 'x' => 1));
$manager->executeInsert(NS, array('_id' => 2, 'x' => 1));

$result = $manager->executeDelete(NS, array('x' => 1), array('limit' => 1));

echo "\n===> WriteResult\n";
printWriteResult($result);

echo "\n===> Collection\n";
$cursor = $manager->executeQuery(NS, new MongoDB\Query(array()));
var_dump(iterator_to_array($cursor));

?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
===> WriteResult
server: %s:%d
insertedCount: 0
matchedCount: 0
modifiedCount: 0
upsertedCount: 0
deletedCount: 1

===> Collection
array(1) {
  [0]=>
  array(2) {
    ["_id"]=>
    int(2)
    ["x"]=>
    int(1)
  }
}
===DONE===
