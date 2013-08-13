#!/usr/bin/ruby

# Written with Ruby 2.0.0-p247
# A ruby script connecting to a MongoDB database given a MongoDB Connection URI.

require 'mongo'
include Mongo

### Standard URI format: mongodb://[dbuser:dbpassword@]host:port/dbname

URI = 'mongodb://sandbox:test@ds039768.mongolab.com:39768/test2345'

begin
  conn = MongoClient.from_uri(URI)
rescue Mongo::ConnectionFailure
  p 'Connection Failed, check uri'
end

db_name = URI[%r{/([^/\?]+)(\?|$)}, 1]
db = conn.db(db_name)

# We'll add a few songs to the database. Nothing is required to create
# the songs collection--it is created automatically when we insert.

songs = db.collection('songs')

songs.insert({
            'name' => 'Jonathan Gillette',
            'nick' => 'why the lucky stiff',
            'related' => {'primary' => 'Ruby', 
                          'secondary' => ['writing', 'music', 'cartoons', 'artistry']
                        }
          })

songs.insert({
            'name' => 'Yukihiro Matsumoto',
            'nick' => 'Matz',
            'related' => {'primary' => 'Heroku', 
                          'secondary' => ['songs', 'writing']
                        }
          })

songs.insert({
            'name' => 'David Heinemeier Hansson',
            'nick' => 'DHH',
            'related' => {'primary' => 'Rails', 
                          'secondary' => ['race car driving']
                        }
          })

songs.update({'name' => 'Jonathan Gillette'}, {'$set' => {'nick' => '_why'}})


# Our query returns a cursor, which can be counted and iterated normally.
# Update changes the order of docs in cursor- use sort if needed.

cursor = songs.find()

cursor.each{|doc| puts "#{doc['name']}," +
                       " also known as #{doc['nick']}," +
                       " is known for his work with #{doc['related']['primary']}"}

### Since this is an example, we'll clean up after ourselves.

songs.drop()
