package com.chris.core;
/*
  Written with mongo-2.10.1.jar
  JavaSingleExample.java
 
  A simple Java class that connects to a MongoDB database given a
  fully-qualified URI. The standard connection practice is using the MongoClient 
  object along with using a connection URI connection model so developers
  can use the same code to handle various database configuration possibilities
  (single, master/slave, replica sets).

  Author::  MongoLab

  First, import MongoDB. You must have the mongo JAR in your build path.
*/

import java.net.UnknownHostException;

import com.mongodb.*;


public class JavaSingleExample {
	
	public static void main(String[] args){
		
		/* 
		  Example URI : mongodb://<dbuser>:<dbpassword>@xx000000.mongolab.com:00000/dbname
		  Your DB user can be found by navigating into your database and clicking on the
	      users tab.
		*/	
		
		MongoClientURI uri = new MongoClientURI("mongodb://sandbox:test@ds039768.mongolab.com:39768/test2345");
		MongoClient mongoClient = null;
		DB db = null;
		try {
			mongoClient = new MongoClient(uri);
			db = mongoClient.getDB(uri.getDatabase());
		} catch (UnknownHostException e) {
			System.out.println("Connection Failed, check uri");
		}
		
		if(db != null){
			
			/*
			  To begin with, we'll add a few hits to the database. Note that
			  nothing is required to create the java collection--it is
			  created automatically when we insert into it. These are simple JSON 
			  objects. 
			*/
			
			DBCollection java = db.getCollection("java");
			
			BasicDBObject seventies = new BasicDBObject();
			seventies.put("decade", "1970s");
			seventies.put("artist", "Debby Boone");
			seventies.put("song", "You Light Up My Life");
			seventies.put("weeksAtOne", "10");
			
			BasicDBObject eighties = new BasicDBObject();
			eighties.put("decade", "1980s");
			eighties.put("artist", "Olivia Newton-John");
			eighties.put("song", "Physical");
			eighties.put("weeksAtOne", "10");
			
			BasicDBObject nineties = new BasicDBObject();
			nineties.put("decade", "1990s");
			nineties.put("artist", "Mariah Carey");
			nineties.put("song", "One Sweet Day");
			nineties.put("weeksAtOne", "16");
			
			BasicDBObject twoThousands = new BasicDBObject();
			twoThousands.put("decade", "2000s");
			twoThousands.put("artist", "Mariah Carey");
			twoThousands.put("song", "We Belong Together");
			twoThousands.put("weeksAtOne", "14");
			
			
			java.insert(seventies);
			java.insert(eighties);
			java.insert(nineties);
			java.insert(twoThousands);
			
			/*
			  Whoops, we forgot to give Boyz II Men credit for their part in the hit
			  One Sweet Day. Let's fix that now.
			*/
			
			BasicDBObject query = new BasicDBObject();
			query.put("song", "One Sweet Day");
			java.update(query, new BasicDBObject("$set", new BasicDBObject("artist", "Mariah Carey ft. Boyz II Men")));
			
			/*
			  Now that all the entries are set and updated for use, let's display them through standard output.
			  Our query returns a cursor, which can be counted and iterated normally.
			  Note that update changes the order of the docs in cursor, use sort if order is important.
			*/
			
			DBCursor docs = java.find();
			while(docs.hasNext()){
				DBObject doc = docs.next();
				System.out.println("In the " + doc.get("decade") + ", " + doc.get("song") + " by " + doc.get("artist") + 
									" topped the charts for " + doc.get("weeksAtOne") + " straight weeks.");
			}
			
			/*
			  Since this is an example, we'll clean up after ourselves.
			*/
			  
			java.drop();
		}
		
	}
}
