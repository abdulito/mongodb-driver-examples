# Written with Ruby 2.0.0-p247
# ruby-single-example.rb
# 
# A simple ruby script covering connection to a MongoDB database given a
# fully-qualified URI. The standard connection practice is using the MongoClient 
# object along with using a connection URI connection model so developers
# can use the same code to handle various database configuration possibilities
# (single, master/slave, replica sets).
#
# Author::  MongoLab

# First, require the ruby MongoDB driver mongo. Must include Mongo to initialize mongo
#


require 'mongo'
include Mongo

# Example URI : mongodb://<dbuser>:<dbpassword>@xx000000.mongolab.com:00000/dbname
# Your DB user can be found by navigating into your database and clicking on the
# users tab.
#

uri = 'mongodb://sandbox:test@ds039768.mongolab.com:39768/test2345'

begin
	client = MongoClient.from_uri(uri)
rescue Mongo::ConnectionFailure
	p 'Connection Failed, check uri'
end

db_name = uri[%r{/([^/\?]+)(\?|$)}, 1]
db = client.db(db_name)

# To begin with, we'll add some Ruby programmers. Note that nothing is required
# to create the ruby collection--it is created automatically when we insert into it. 
# We can also access the collection in multiple ways. These are simple JSON 
# objects.
#

db['ruby'].insert({'name' => 'Jonathan Gillette',
					'nick' => 'why the lucky stiff',
					'related' => {'primary' => 'Ruby', 'secondary' => ['writing', 'music', 'cartoons', 'artistry']}})

ruby = db.collection('ruby')

ruby.insert({'name' => 'Yukihiro Matsumoto',
			'nick' => 'Matz',
			'related' => {'primary' => 'Heroku', 'secondary' => ['ruby', 'writing']}})

ruby.insert({'name' => 'David Heinemeier Hansson',
			'nick' => 'DHH',
			'related' => {'primary' => 'Rails', 'secondary' => ['race car driving']}})

# Since Jonathan's nickname is a bit lengthy, let's shorten it. 
#
# Note that in Ruby, MongoDB $ operators should be quoted.
#

ruby.update({'name' => 'Jonathan Gillette'}, {'$set' => {'nick' => '_why'}})


# Our query returns a Cursor, which can be counted and iterated 
# normally.
#

cursor = ruby.find()

cursor.find().each{|doc| puts doc['name'] + ', also known as ' + doc['nick'] + ', is known for his work with ' + doc['related']['primary']}

# Since this is an example, we'll clean up after ourselves.
#

ruby.drop()
