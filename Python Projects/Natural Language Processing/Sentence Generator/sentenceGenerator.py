'''
Author: Elozino Egonmwan
Language Modelling 
Generates random sentences using Bigram Model
15.02.2017
'''
import nltk
import numpy as np
import random
from nltk.corpus import brown

puncts = "!#$%&\'()*+,''-./:;<=>?@[\\]^_`{|}``--"

def randSents(sentence):
     tokens, bigramModel = lang_model() #get Bigrams     
     numberOfSents = random.randint(3,5)   
     for i in range(numberOfSents):
        print randomSentGenerator(sentence,tokens,bigramModel)
     print "END"

def lang_model(): 
    data = brown.words(categories='humor')[:10000]      
    tokens = [t.lower() for t in data if not t in puncts]              
    bigrms = nltk.bigrams(tokens)
    bigramModel = nltk.FreqDist(bigrms)
    return tokens,bigramModel
     
def randomSentGenerator(sentence,tokens,bigramModel):
    lengthOfSent = random.randint(3,10) 
    vocab,freq = getVocabulary(tokens,5) #words that occured at least 5 times
    for i in range(lengthOfSent):
        sentence = getRandomSent(sentence,vocab,freq,bigramModel)
    return sentence 

def getVocabulary(tokens,minFreq):     
    vocab = sorted(set(tokens))    
    fdist = nltk.FreqDist(tokens) 
    vocab = [word for word in vocab if fdist[word] >= minFreq] 
    freq = [fdist[word] for word in vocab]     
    return vocab,freq
    
def getRandomSent(sentence,vocab,freq,bigramModel): 
    nVocab = len(vocab)
    sent = processSent(sentence)    
    n = len(sent)   
    if (n > 1):
       sent = sent[n-1:] 
    if (n == 0):
        sentence = random.choice(vocab) 
       
    #initialize probabilities to (1/frq+ |V|)    
    probs = [float (1)/(frequency + nVocab) for frequency in freq]    
    for i in range(nVocab):        
        s = list(sent) #refresh
        s.append(vocab[i])
        s = tuple(s)          
        probs[i] = float (getFreq(bigramModel,s) + 1)/(freq[i] + nVocab)
        
    #index = np.argmax(probs)
    maxProb = np.amax(probs)
    maxIndices = [ind for ind in range(len(probs)) if probs[ind] == maxProb]
    index = random.choice(maxIndices)
    randSent = sentence + " " + vocab[index]
    return randSent    
            
def processSent(sentence):
    sent = [s.lower() for s in nltk.word_tokenize(sentence) if not s in puncts]
    return sent
    
def getFreq(bigramModel,sent):  
    freqBigram = 0
    for bigram,freq in bigramModel.items():        
        if (bigram == sent):
            freqBigram = freq 
    return freqBigram
                
if __name__ == "__main__":
    randSents(""); 
    
