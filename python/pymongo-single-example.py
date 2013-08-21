#!/usr/bin/python

__author__ = 'mongolab'

# Written with pymongo-2.5.2
# A python script connecting to a MongoDB database given a MongoDB Connection
#  URI.

import sys
import pymongo

### Standard URI format: mongodb://[dbuser:dbpassword@]host:port/dbname

URI = 'mongodb://sandbox:test@ds039768.mongolab.com:39768/test2345' 

###############################################################################
# main
###############################################################################


def main(args):

    try:
        conn = pymongo.MongoClient(URI)
    except Exception, err:
        print 'Error: %s' % err
        return

    uri_parts = pymongo.uri_parser.parse_uri(URI)
    db_name = uri_parts['database']
    db = conn[db_name]

    # We'll add a few songs to the database. Nothing is required to create
    # the songs collection--it is created automatically when we insert.

    songs = db['songs']

    songs.insert(
        {
            'decade': '1970s',
            'artist': 'Debby Boone',
            'song': 'You Light Up My Life',
            'weeksAtOne': 10
        }
    )

    songs.insert(
        {
            'decade': '1980s',
            'artist': 'Olivia Newton-John',
            'song': 'Physical',
            'weeksAtOne': 10
        }
    )

    songs.insert(
        {
            'decade': '1990s',
            'artist': 'Mariah Carey',
            'song': 'One Sweet Day',
            'weeksAtOne': 16
        }
    )

    songs.insert(
        {
            'decade': '2000s',
            'artist': 'Mariah Carey',
            'song': 'We Belong Together',
            'weeksAtOne': 14
        }
    )

    query = {'song': 'One Sweet Day'}

    songs.update(query, {'$set': {'artist': 'Mariah Carey ft. Boyz II Men'}})

    # Our query returns a cursor, which can be counted and iterated normally.
    # Update changes the order of docs in cursor- use sort if needed.
    
    cursor = songs.find({'weeksAtOne': {'$gt': 10}})

    for doc in cursor:
        print ('In the %s, %s by %s topped the charts for %d straight weeks.' %
               (doc['decade'], doc['song'], doc['artist'], doc['weeksAtOne']))
    
    ### Since this is an example, we'll clean up after ourselves.

    db.drop_collection('songs')


if __name__ == '__main__':
    main(sys.argv[1:])
