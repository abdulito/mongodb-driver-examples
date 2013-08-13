<?php

/*
  Written with mongo 1.4.2
  A PHP script connecting to a MongoDB database given a MongoDB Connection URI.
*/

// Standard URI format: mongodb://[dbuser:dbpassword@]host:port/dbname

$uri = "mongodb://sandbox:test@ds039768.mongolab.com:39768/test2345";
$m = new MongoClient($uri);
preg_match("{/([^/\?]+)(\?|$)}",$uri, $matches);

$db_name = $matches[1];

$db = $m->$db_name;

$songs = $db->'songs';

/*
  We'll add a few songs to the database. Nothing is required to create
  the songs collection--it is created automatically when we insert.
*/

$obj = array('decade' => '1970s', 'artist' => 'Debby Boone',
             'song' => 'You Light Up My Life', 'weeksAtOne' => 10);

$songs->insert($obj);

$obj2 = array('decade' => '1980s', 'artist' => 'Olivia Newton-John',
              'song' => 'Physical', 'weeksAtOne' => 10);

$songs->insert($obj2);

$obj3 = array('decade' => '1990s', 'artist' => 'Mariah Carey',
              'song' => 'One Sweet Day', 'weeksAtOne' => 16);

$songs->insert($obj3);

$obj4 = array('decade' => '2000s', 'artist' => 'Mariah Carey',
              'song' => 'We Belong Together', 'weeksAtOne' => 14);

$songs->insert($obj4);

$songs->update(array('artist' => 'Mariah Carey'), 
               array('$set' => array('artist' => 'Mariah Carey ft. Boyz II Men')));
    
/*
  Our query returns a cursor, which can be counted and iterated normally.
  Update changes the order of docs in cursor- use sort if needed.
*/

$cursor = $songs->find(array());

foreach($cursor as $doc) {
                          echo 'In the ' .$doc['decade'];
                          echo ', ' .$doc['song']; 
                          echo ' by ' .$doc['artist'];
                          echo ' topped the charts for ' .$doc['weeksAtOne'];
                          echo ' straight weeks.', "\n";
                      }
    

//Since this is an example, we'll clean up after ourselves.

$songs->drop();

/* End of file php-single-example.php */