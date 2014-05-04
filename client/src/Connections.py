import networkx as nx
import sys

class Connections:
    
    def __init__(self, characters):
        # Initialise data values
        self.characters = characters
        self.connections = []
        self.largest_connection = 0
        self.largest_occurrences = 0
        
        # Find the connections
        self.find_connections()
        self.graph_coordinates()
        
    """ Find connections between characters """
    def find_connections(self):
        # Find connections for each character
        for idx, character in enumerate(self.characters):
            # Track the occurrences
            occurrences = len(self.characters[idx]['sentences'])
            if occurrences > self.largest_occurrences:
                self.largest_occurrences = occurrences
            
            # Add to connection array
            self.connections.append({
                'name': self.characters[idx]['name'],
                'connections': self.compare_sentence_occurrences(character),
                'occurrences': occurrences
            })
            
        # Update the strength of each relationship & occurrences (between 0-1)
        self.update_occurrence_strengths()
        self.update_connection_strengths()
    

    """ Update the strength of the connections (put between 0-1) """
    def update_occurrence_strengths(self):
        for idx, character in enumerate(self.connections):
            occurrences = character['occurrences']
            occurrence_weighted = round(float(occurrences) / float(self.largest_occurrences), 8)
            self.connections[idx]['weighting'] = occurrence_weighted
                
                
    """ Update the strength of the connections (put between 0-1) """
    def update_connection_strengths(self):
        for idx, character in enumerate(self.connections):
            try:
                for connection_idx, connection in enumerate(character['connections']):                   
                    # Get target character's weighting
                    target_char = self.get_character_by_name(connection['name'])
                    target_weighting = target_char['weighting']
                    average_weighting = round((float(target_weighting) + float(character['weighting'])) / 2.0, 8)
                    
                    # Calculate the relationship strength (amount of connections (weighted) * average(character weighting))
                    strength = connection['strength']
                    new_strength = round(float(strength) / float(self.largest_connection), 8)
                    self.connections[idx]['connections'][connection_idx]['strength'] = new_strength
            finally:
                pass
                
    """ Retrieve a character entry by name """
    def get_character_by_name(self, name):
        for idx, character in enumerate(self.connections):
            if character['name'] == name:
                return character
                
        return []
                
    """ Find the graph coordinates for connections """
    def graph_coordinates(self):
        graph = nx.Graph()
        
        # Iterate through and add edges based on the strength of each relationship
        for idx, character in enumerate(self.connections):
            try:
                for connection_idx, connection in enumerate(character['connections']):
                    graph.add_edge(character['name'], connection['name'], weight=connection['strength'])
            finally:
                pass
                
        pos = nx.spring_layout(graph)
        
        # Update the connections in the class list
        for idx, connection in enumerate(self.connections):
            try:
                if connection['name'] in pos:
                    self.connections[idx]['spring_coordinates'] = [
                        round(pos[connection['name']][0], 8),
                        round(pos[connection['name']][1], 8)
                    ]
                else:
                    self.connections[idx]['spring_coordinates'] = [0,0]
            finally:
                pass


    """ Compare sentence occurrences """
    def compare_sentence_occurrences(self, char):
        char_set = set(char['sentences'])
        connections = []
        
        for idx, character in enumerate(self.characters):
            if character['name'] != char['name']:
                compare_set = set(character['sentences'])
                intersections = char_set & compare_set
                num_connections = len(intersections)
                
                # If we have connections, store it
                if num_connections > 0:
                    # Track what the largest number of connections are
                    if num_connections > self.largest_connection:
                        self.largest_connection = num_connections
                        
                    connections.append({
                        'name': character['name'], 
                        'strength': num_connections
                    })
                    
        return connections