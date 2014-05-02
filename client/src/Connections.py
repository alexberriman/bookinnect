import sys

class Connections:
    
    def __init__(self, characters):
        self.characters = characters
        self.connections = []
        self.find_connections()
        
    """ Find connections between characters """
    def find_connections(self):
        # Find connections for each character
        for idx, character in enumerate(self.characters):
            self.connections.append({
                'name': self.characters[idx]['name'],
                'connections': self.compare_sentence_occurrences(character),
                'occurrences': len(self.characters[idx]['sentences'])
            })
            
    """ Compare sentence occurrences """
    def compare_sentence_occurrences(self, char):
        char_set = set(char['sentences'])
        connections = []
        
        for idx, character in enumerate(self.characters):
            if character['name'] != char['name']:
                compare_set = set(character['sentences'])
                intersections = char_set & compare_set
                if len(intersections) > 0:
                    connections.append(character['name'])
                
        return connections