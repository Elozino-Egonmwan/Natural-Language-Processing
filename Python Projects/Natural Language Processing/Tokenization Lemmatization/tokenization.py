'''
Author: Elozino Egonmwan
Tokenisation and Types
02.02.2017
'''

from nltk.tokenize import RegexpTokenizer
from nltk.stem.wordnet import WordNetLemmatizer
from nltk.stem.porter import PorterStemmer

def nlp_tokenizer(File): 
    tokenizer = RegexpTokenizer('\w+')    
    file = open(File,"r")
    data = file.read()    
    print data
    file.close()
    tokens = [d.lower() for d in tokenizer.tokenize(data)]
        
    #Comparing Lemmatization to Stemming
    lemmatizer = WordNetLemmatizer()
    lemma = [lemmatizer.lemmatize(t) for t in tokens]  
    
    porterStemmer = PorterStemmer()
    porter = [porterStemmer.stem(t) for t in tokens]    
    display(tokens,lemma,porter)
    

#printing the tokens and their different transformations using Lemmatizer and Stemmer    
def display(tokens,lemma, porter):
    numTokens = len(tokens)
    nWordNet_types = len(set(lemma)) #get unique words#
    nPorter_types = len(set(porter))
    print "%10s%20s%20s%20s\n" %('S/N', 'TOKEN', 'WORDNET','PORTER')
    for i in range(numTokens):
        print "%10d%20s%20s%20s" % (i, tokens[i], lemma[i], porter[i])
        
    print "\nNumber of Tokens: %s" %numTokens
    print "Number of Word Types using WordNet Lemmatizer: %d" %nWordNet_types
    print "Number of Word Types using Porter Stemmer: %d" %nPorter_types   

if __name__ == "__main__":
    nlp_tokenizer("data.txt");   