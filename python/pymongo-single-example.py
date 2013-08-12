# Written with pymongo-2.5.2
# pymongo_example_simple.py
# 
# A simple python script covering connection to a MongoDB database given a
# fully-qualified URI. The standard connection practice is using the MongoClient 
# object along with using a connection URI connection model so developers
# can use the same code to handle various database configuration possibilities
# (single, master/slave, replica sets).
#
# Author::  MongoLab

# First, require the pymongo MongoDB driver.
#

import sys
import pymongo

# Example URI : mongodb://<dbuser>:<dbpassword>@xx000000.mongolab.com:00000/dbname
# Your DB user can be found by navigating into your database and clicking on the
# users tab.
#
 
def main(args):
	uri = 'mongodb://sandbox:test@ds039768.mongolab.com:39768/test2345'
	try:
		client = pymongo.MongoClient(uri)
	except Exception, err:
		print 'Error: %s' %(err)
		return
	uri_parts = pymongo.uri_parser.parse_uri(uri)
	db = client[uri_parts['database']]


	# To begin with, we'll add a few hits to the database. Note that
	# nothing is required to create the python collection--it is
	# created automatically when we insert into it. These are simple JSON 
	# objects. Pymongo also allows for multiple ways to designate the 
	# collection to be queried to.

	db['python'].insert({'decade':'1970s',
						'artist':'Debby Boone',
						'song': 'You Light Up My Life',
						'weeksAtOne':'10'})

	python = db.python

	python.insert({'decade':'1980s',
					'artist': 'Olivia Newton-John',
					'song': 'Physical',
					'weeksAtOne': '10'})

	python.insert({'decade':'1990s',
					'artist': 'Mariah Carey',
					'song': 'One Sweet Day',
					'weeksAtOne': '16'})

	python.insert({'decade':'2000s',
					'artist': 'Mariah Carey',
					'song': 'We Belong Together',
					'weeksAtOne': '14'})
	
	# Looks like we forgot to give credit to Boyz II Men, let's update now.
	#
	# Note that in python, MongoDB $ operators should be quoted.
	#


	db.python.update({'song':'One Sweet Day'},
					{'$set':{'artist':'Mariah Carey ft. Boyz II Men'}})


	# Now that all the entries are set and updated for use, let's display
	# them through standard output.
	# Our query returns a Cursor, which can be counted and iterated normally.
	# Note that update changes the order of the docs in cursor, use sort if order is important.
	
	cursor = db.python.find()

	for doc in cursor:
		print ('In the %s, %s by %s topped the charts for %s straight weeks.'
				% (doc['decade'], doc['song'], doc['artist'], doc['weeksAtOne']))

	# Since this is an example, we'll clean up after ourselves.
	#

	db.drop_collection('python')



if __name__ == '__main__':
	main(sys.argv[1:])