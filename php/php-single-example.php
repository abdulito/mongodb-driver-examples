<?php

/*
  Written with mongo 1.4.2
  php_simple_example.php

  A simple php script covering connection to a MongoDB database given a
  fully-qualified URI. The standard connection practice is using the MongoClient 
  object along with using a connection URI connection model so developers
  can use the same code to handle various database configuration possibilities
  (single, master/slave, replica sets).
 
  Be sure to add extension=mongo.so to your php.ini file.
 
  Author::  Mongolab

  Example URI : mongodb://<dbuser>:<dbpassword>@xx000000.mongolab.com:00000/dbname
  Your DB user can be found by navigating into your database and clicking on the
  users tab.
*/

$uri = "mongodb://sandbox:test@ds039768.mongolab.com:39768/test2345";
$m = new MongoClient($uri);
preg_match("{/([^/\?]+)(\?|$)}",$uri, $matches);

$db_name = $matches[1];

$db = $m->$db_name;

/*
  To begin with, we'll add a few hits to the database. Note that
  nothing is required to create the php collection--it is
  created automatically when we insert into it. These are simple JSON 
  objects.
*/

$collection = $db->PHP;

/*
  We insert by first creating an array, and passing that array to
  the collection's insert function. We use arrays to construct
  JSON-like objects.
*/

$obj = array('decade' => '1970s', 'artist' => 'Debby Boone',
			'song' => 'You Light Up My Life', 'weeksAtOne' => 10);
$collection->insert($obj);
$obj2 = array('decade' => '1980s', 'artist' => 'Olivia Newton-John',
			'song' => 'Physical', 'weeksAtOne' => 10);
$collection->insert($obj2);
$obj3 = array('decade' => '1990s', 'artist' => 'Mariah Carey',
			'song' => 'One Sweet Day', 'weeksAtOne' => 16);
$collection->insert($obj3);
$obj4 = array('decade' => '2000s', 'artist' => 'Mariah Carey',
			'song' => 'We Belong Together', 'weeksAtOne' => 14);
$collection->insert($obj4);

/*
  Looks like we forgot to give credit to Boyz II Men, let's update now.

  Note that in PHP, MongoDB $ operators should be quoted.
*/

$collection->update(array('artist' => 'Mariah Carey'), 
					array('$set' => array('artist' => 'Mariah Carey ft. Boyz II Men')));
    
/*
  Now that all the entries are set and updated for use, let's display
  them through standard output.

  Our query returns a Cursor, which can be counted and iterated normally.

  Note that update changes the order of the docs in cursor, use sort if order is important.
*/

$cursor = $collection->find(array());
foreach($cursor as $doc) {
    echo 'In the ' .$doc['decade'];
    echo ', ' .$doc['song']; 
    echo ' by ' .$doc['artist'];
    echo ' topped the charts for ' .$doc['weeksAtOne'];
    echo ' straight weeks.', "\n";
}
    
/*
  Since this is an example, we'll clean up after ourselves.
*/

$collection->drop();

?>