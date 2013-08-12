/*
  Written with: mongodb@1.3.17
  node-single-example.js

  A simple node script covering connection to a MongoDB database given a
  fully-qualified URI. There are a few alternate methods, but we prefer the URI
  connection model so developers can use the same code to handle various
  database configuration possibilities (single, master/slave, replica sets).

  Author::  MongoLab

*/

// First, require the node MongoDB package. Initialize MongoClient

var MongoClient = require('mongodb').MongoClient;

/* 
  Example URI : mongodb://<dbuser>:<dbpassword>@xx000000.mongolab.com:00000/dbname
  Your DB user can be found by navigating into your database and clicking on the
  users tab.
*/	

var uri = 'mongodb://sandbox:test@ds039768.mongolab.com:39768/test2345';

var mongoClient = MongoClient.connect(uri, function(err,db){

	/*
	  To begin with, we'll add a few hits to the database. Note that
	  nothing is required to create the java collection--it is
	  created automatically when we insert into it. These are simple JSON 
	  objects. 
	*/

	var node = db.collection('node');

	node.insert({'decade':'1970s',
				'artist': 'Debby Boone',
				'song': 'You Light Up My Life',
				'weeksAtOne': '10'
	}, function(err, docs){});

	node.insert({'decade':'1980s',
				'artist': 'Olivia Newton-John',
				'song': 'Physical',
				'weeksAtOne': '10'
	}, function(err, docs){});

	node.insert({'decade':'1990s',
				'artist': 'Mariah Carey',
				'song': 'One Sweet Day',
				'weeksAtOne': '16'
	}, function(err, docs){});

	node.insert({'decade':'2000s',
				'artist': 'Mariah Carey',
				'song': 'We Belong Together',
				'weeksAtOne': '14'
	}, function(err, docs){});

	
	// Looks like we forgot to give credit to Boyz II Men, let's update now.

	node.update({'song':'One Sweet Day'}, {$set:{'artist':'Mariah Carey ft. Boyz II Men'}}, function(err){

		node.find({}).toArray(function(err,docs){
			for(var i = 0; i < docs.length; i++){
				var doc = docs[i];
				console.log('In the ' + doc['decade'] + ', ' + doc['song'] + ' by ' + doc['artist'] 
							+ ' topped the charts for ' + doc['weeksAtOne'] + ' straight weeks.');
			}
		});
	});

	/*
	  Now that all the entries are set and updated for use, let's display them through standard output.
	  Our query returns a cursor, which can be counted and iterated normally.
	  Note that update changes the order of the docs in cursor, use sort if order is important.
	*/

	
});