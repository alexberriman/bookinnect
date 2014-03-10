import re
import xml.etree.ElementTree as ET

class CoreNLPParser:

    """ 
    Character referencing words. Certain words reference a character previously
    mentioned (i.e. he, she)
    """
    character_referencing_words = ['he', 'she']
    
    """ The last character that has been mentioned """
    last_character = ''
    
    """ The characters detected in the xml file """
    characters = {}
    
    def __init__(self, filename=None):
        """ Open up the xml file for processing """
        self.filename = filename
            
            
    def parse(self):
        """ Parse the XML file and get character information """
        tree = ET.parse(self.filename)
        root = tree.getroot()
        
        # Iterate through each sentence
        for xml_sentence in root.iter('sentence'):
            sentence = []
            
            # If no valid sentence id, continue
            if 'id' not in xml_sentence.attrib:
                continue
            
            # Create a dictionary instance of the sentence
            for token in xml_sentence.iter('token'):
                sentence.append({
                    'pos': token.find('POS').text,
                    'word': token.find('word').text,
                    'lemma': token.find('lemma').text,
                    'ner': token.find('NER').text
                })
            
            # Parse the sentence
            self.parse_sentence(sentence, xml_sentence.attrib['id'])
            
            #if xml_sentence.attrib['id'] == '10':
            #    return
        
        
    def parse_sentence(self, sentence, sentence_number):
        """ Parse an individual sentence """
        character = []
        
        # Iterate through all words in the sentence
        for key, word in enumerate(sentence):            
            """ If the current word has been classified as a person, look ahead
            at the next word. If it's also a person, then we want to hold off
            on processing. """
            
            if word['ner'] == 'PERSON':
                character.append(word['word'])
                try:
                    next_word = sentence[key+1]
                    if next_word['ner'] == 'PERSON':
                        continue
                except:
                    pass
                    
                # Add the character and remove the list
                self.add_character(character, sentence_number)
                del character[0:len(character)]
                
            """ If we have a named pronoun, look ahead to see if it's followed
            by a person. i.e. Mr.(NNP-0) Dursley(NNP-PERSON) should be treated
            as 'Mr. Dursley' and not 'Dursley'. """
            
            try:
                if word['pos'] == 'NNP' and word['ner'] == 'O':
                    next_word = sentence[key+1]
                    if next_word['ner'] == 'PERSON':
                        character.append(word['word'])
            except:
                pass
                
            """ If a character referencing word, treat it as the last char """
            if word['lemma'] in self.character_referencing_words:
                self.add_character(self.last_character, sentence_number)
                        
                        
    def add_character(self, character, sentence_number):
        """ A character has been detected. Need to track it. """
        
        # Retrieve the character name in to the correct format
        if type(character) is list:
            char_name = ' '.join(character)
        elif type(character) is str:
            char_name = character
            
        # Make sure sentence number is an int
        if type(sentence_number) is not int:
            sentence_number = int(sentence_number)
            
        # Strip special characters from the character name
        char_name = re.sub(
            '[^A-Za-z0-9\s\.\-]+', 
            '', char_name)
            
        # Mark this character as the last processed char (for referencing)
        self.last_character = char_name
        
        # Add the character
        if char_name in self.characters:
            self.characters[char_name]['occurrences'] += 1
            self.characters[char_name]['sentences'].append(sentence_number)
        else:
            self.characters[char_name] = {
                'occurrences': 1,
                'sentences': [sentence_number]
            }