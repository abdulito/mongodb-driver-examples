# Written with Ruby 2.0.0-p247
# ruby-single-example.rb
# 
# A simple ruby script covering connection to a MongoDB database given a
# fully-qualified URI. The standard connection practice is using the MongoClient 
# object and URI connection model so that developers can use the same code to 
# handle various database configuration possibilities (single, master/slave, replica sets).
#
# Author::  MongoLab

# First, require the ruby MongoDB driver mongo. Must include Mongo to initialize mongo
#


require 'mongoid'

uri = 'mongodb://sandbox:test@ds039768.mongolab.com:39768/test2345'

dbn