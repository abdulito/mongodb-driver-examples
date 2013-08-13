/*
  Written with: mongodb@1.3.17
  A Node script connecting to a MongoDB database given a MongoDB Connection URI.
*/

var MongoClient = require('mongodb').MongoClient;

// Standard URI format: mongodb://[dbuser:dbpassword@]host:port/dbname

var uri = 'mongodb://sandbox:test@ds039768.mongolab.com:39768/test2345';

var mongoClient = MongoClient.connect(uri, function(err,db){

  /*
    We'll add a few songs to the database. Nothing is required to create
    the songs collection--it is created automatically when we insert.
  */

  var songs = db.collection('songs');

  songs.insert({
    decade: '1970s',
    artist: 'Debby Boone',
    song: 'You Light Up My Life',
    weeksAtOne: 10,
  }, function(err, docs){});

  songs.insert({
    decade:'1980s',
    artist: 'Olivia Newton-John',
    song: 'Physical',
    weeksAtOne: 10,
  }, function(err, docs){});

  songs.insert({
    decade:'1990s',
    artist: 'Mariah Carey',
    song: 'One Sweet Day',
    weeksAtOne: 16,
  }, function(err, docs){});

  songs.insert({
    decade:'2000s',
    artist: 'Mariah Carey',
    song: 'We Belong Together',   
    weeksAtOne: 14,
  }, function(err, docs){});

  songs.update({'song':'One Sweet Day'}, {$set:{'artist':'Mariah Carey ft. Boyz II Men'}}, function(err){

    songs.find({}).toArray(function(err,docs){

      for(var i = 0; i < docs.length; i++){
        var doc = docs[i];
        console.log(
          'In the ' + doc['decade'] + ', ' + doc['song'] + ' by ' + doc['artist'] + 
          ' topped the charts for ' + doc['weeksAtOne'] + ' straight weeks.'
        );
      }
      songs.drop();
      db.close();
    });
  });
});