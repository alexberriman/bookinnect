import re

"""A book in it's raw state.

This class is designed to take as input a raw book in the form of a .txt file,
and with that book pre-process it to the point where it's later able to be
analysed.

Example:
    When initialising the class:
    
        $ python
            from raw_book import RawBook
            book = RawBook('books/book_name.txt')
            
            # Tidy up the book (remove data inconsistencies)
            book.tidy()
"""

class RawBook:

    def __init__(self, filename=None):
        """ Initialise the class and open a file/book if specified """
        if filename is not None:
            file = open(filename, 'r')
            self.raw_data = self.data = file.read()
            
    def tidy(self):
        """ 
        In many instances the data will need to be cleaned up prior to it
        being processed. Various tasks that need to be performed on the data
        include:
        
            - Resolve encoding issues
            - Removing special characters. Allowed:
                A-Za-z0-9\s.'"?.;:
            - Removing multiple spaces (hello   world -> hello world)
        """
        
        # Convert to utf8
        self.data = unicode(self.data, "utf-8")
        
        # Replace erroneous single quotes
        self.data = re.sub(
            u'[\u02bc\u2018\u2019\u201a\u201b\u2039\u203a\u300c\u300d]',
            "'", self.data)
        
        # Replace erroneous double quotes
        self.data = re.sub(
            u'[\u00ab\u00bb\u201c\u201d\u201e\u201f\u300e\u300f]',
            '"', self.data)
            
        # Replace an emdash with a normal dash
        self.data = re.sub(u'[\u2014]', '-', self.data)
        
        # Replace the horizontal ellipsis (...) with three periods
        self.data = re.sub(u'[\u2026]', '...', self.data)
        
        # Remove special chars
        self.data = re.sub(
            '[^A-Za-z0-9\s\.\\\'\"\?\,\;\:\n\-]+', 
            '', self.data)
            
        # Remove double spaces
        self.data = re.sub('[ ]{2,}', ' ', self.data)
        
    def save(self, filename='book.txt'):
        """ Save the book data to a file """
        file = open(filename, 'w')
        file.write(self.data)
        file.close()