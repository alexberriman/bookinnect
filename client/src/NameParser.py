import re
import sys
import sqlite3
import nltk
from nameparser.parser import HumanName

class NameParser:

    def __init__(self, names):
        self.names = names
        self.checked = []
        self.connection_matrix = []
        self.parsed = []
    
    def parse(self):
        # Create the database in memory
        self.db = sqlite3.connect(':memory:')

        # Create the person table
        cursor = self.db.cursor()
        cursor.execute('CREATE TABLE person (person_id PRIMARY KEY, full_name TEXT, title TEXT, first_name TEXT, middle_name TEXT, last_name TEXT, suffix TEXT, occurrences INTEGER, sentences TEXT)');

        # Test if same person
        idx = 0
        for character in self.names:
            idx += 1
            name = HumanName(character)
            
            # Insert the person
            cursor.execute(
                'INSERT INTO person(person_id, full_name, title, first_name, middle_name, last_name, suffix, occurrences, sentences) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', 
                (
                    idx, character, name.title.lower(), name.first.lower(), 
                    name.middle.lower(), name.last.lower(), 
                    name.suffix.lower(), 
                    self.names.get(character).get('occurrences'), 
                    ','.join([str(x) for x in self.names.get(character).get('sentences')])
                )
            )

        # Find similar names
        cursor.execute("""SELECT p1.person_id, p2.person_id
        FROM person p1
        INNER JOIN person AS p2
        WHERE 
        p1.person_id != p2.person_id AND
        LOWER(p1.first_name) NOT IN ('mrs', 'miss', 'ms', 'sister', 'daughter', 'dame', 'queen', 'princess', 'lady', 'mother', 'auntie', 'aunt', 'grandmother', 'wife', 'mr', 'brother', 'son', 'father', 'reverend', 'sir', 'king', 'prince', 'master', 'dude', 'uncle', 'grandfather', 'husband', 'professor', 'mr.', 'mrs.') AND
        (
            (
                length(p1.first_name) > 0 AND
                length(p1.last_name) > 0 AND
                p1.first_name = p2.first_name AND
                p1.last_name = p2.last_name
            )
            OR
            (
                length(p1.last_name) > 0 AND
                p1.last_name = p2.last_name AND
                length(p1.first_name) = 0
            )
            OR
            (
                length(p1.title) > 0 AND
                length(p1.first_name) > 0 AND
                p1.title = p2.title AND
                p1.first_name = p2.first_name
            )
            OR
            (
                length(p1.title) > 0 AND
                length(p1.last_name) > 0 AND
                p1.title = p2.title AND
                p1.last_name = p2.last_name
            )
            OR
            (
                length(p1.first_name) > 0 AND
                p1.first_name = p2.first_name AND
                LOWER(p1.title) NOT IN ('mrs', 'miss', 'ms', 'sister', 'daughter', 'dame', 'queen', 'princess', 'lady', 'mother', 'auntie', 'aunt', 'grandmother', 'wife', 'mr', 'brother', 'son', 'father', 'reverend', 'sir', 'king', 'prince', 'master', 'dude', 'uncle', 'grandfather', 'husband', 'professor', 'mr.', 'mrs.') 
            )
        )

        ORDER BY p1.person_id ASC
        """
        )
        
        # Create the connections
        all_rows = cursor.fetchall()
        self.connections = []
        for row in all_rows:
            self.connections.append([row[0], row[1]])
            
        # Group all of the people
        cursor.execute("SELECT person_id FROM person ORDER BY occurrences DESC")
        for person in cursor.fetchall():
            person_id = person[0]
            self.find_connections(person_id)
            
        # Commit changes
        self.db.commit()
        
        # Collate the changes
        self.collate()
        
        # Close the db
        self.db.close()
        
    """
    Collate the results
    """
    def collate(self):
        cursor = self.db.cursor()
        for connection in self.connection_matrix:
            # Fetch the persons from the database
            connection_ids = ','.join([str(x) for x in connection])
            cursor.execute('SELECT * FROM person WHERE person_id IN (%s) ORDER BY occurrences DESC' % connection_ids)
            
            # Iterate through the persons objects
            person_obj = {}
            for person in cursor.fetchall():
                # If object not set, set the main name
                if 'name' not in person_obj:
                    person_obj['name'] = person[1]
                    person_obj['sentences'] = []
                    
                # Merge the sentences the characters are in
                person_obj['sentences'] = list(set(person[8].split(',') + person_obj['sentences']))
                    
            self.parsed.append(person_obj)
            
        
    """
    Finds connections between all of the people in the database
    """
    def find_connections(self, person_id):
        connections = [person_id]
        people_to_check = [person_id]
        
        # If the person has been checked before
        if person_id in self.checked:
            return
            
        self.checked.append(person_id)
        
        # Iterate through and add all of the connections
        while len(people_to_check) > 0:
            # The person id being checked
            to_check = people_to_check[0]
            
            for connection in self.connections:
                if to_check in connection:
                    for pid in connection:
                        # Want the person id of the related person
                        if pid == to_check:
                            continue
                            
                        # If we come across a new connection that hasn't been logged, check it
                        if pid not in connections:
                            connections.append(pid)
                            
                            # If the person id hasn't been checked before, add it
                            if pid not in self.checked:
                                people_to_check.append(pid)
            
            # Delete from list
            self.checked.append(to_check)
            del people_to_check[0]
            
        self.connection_matrix.append(connections)