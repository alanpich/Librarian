<?php
use AlanPich\Librarian\Indexer;

require dirname(__FILE__) . '/vendor/autoload.php';


// Set up a dummy data object to index
require dirname(__FILE__) . '/examples/DummyDataObject.php';
require dirname(__FILE__) . '/examples/DummyContentMap.php';
$dummyResource = new DummyDataObject(1);

// Generate a contentMapper for the dummy data
$dummyMapper = new DummyContentMap();


//$map = new \AlanPich\Librarian\ObjectContentMap();

$tokenizer = new \AlanPich\Librarian\Tokenizer();
$persistor = new \AlanPich\Librarian\Persistor\mySQLPersistor();


$IND = new \AlanPich\Librarian\Indexer( $dummyMapper, $tokenizer, $persistor );



$IND->indexResource(1,$dummyResource,$dummyMapper);
