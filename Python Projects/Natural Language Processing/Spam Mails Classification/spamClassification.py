'''
Author: Elozino Egonmwan
Document Classification
Classifies mails as spam:0 or legit(non-spam):1 using Naive Bayes Classifier
15.02.2017
'''

import math
from nltk.metrics import accuracy
from sentenceGenerator import processSent,getVocabulary

def spamClassifier():    
    spamDocs = ["train_spm1.txt","train_spm2.txt","train_spm3.txt"]
    legitDocs = ["train_msg1.txt","train_msg2.txt","train_msg3.txt"]

    nSpamDocs = len(spamDocs)
    nLegitDocs = len(legitDocs)
    prior_prob_spam = float (nSpamDocs)/ (nSpamDocs + nLegitDocs)
    prior_prob_legit = float (nLegitDocs)/ (nSpamDocs + nLegitDocs)
    #print "%20s%10s%20s%10s" % ("P(Spam): ", prob_spam, "P(Legit): ", prob_legit)

    megaSpamDocs = processSent(megaDocument(spamDocs))    
    vocabSpam, freqSpam = getVocabulary(megaSpamDocs,1)
    
    megaLegitDocs = processSent(megaDocument(legitDocs))
    vocabLegit, freqLegit = getVocabulary(megaLegitDocs,1)    
            
    megaDoc = megaLegitDocs + megaSpamDocs
    _, nVocab = getVocabulary(megaDoc,1)
    
    docToClassify = ["test_spm4.txt","test_spm5.txt","test_spm6.txt","test_msg4.txt","test_msg5.txt"]
    reference = [0,0,0,1,1]      
    print "\nKEY\n1: LEGIT     0:SPAM" 
    print "\n%20s%20s" % ("Reference: ",reference)
    
    pred = [1 for j in range(len(docToClassify))]    #initialize to 1   
    for i in range(len(docToClassify)):
        file = open(docToClassify[i],"r")
        doc = processSent(file.read())
        probLegit = computeProbs(doc,vocabLegit,freqLegit,megaLegitDocs,nVocab,prior_prob_legit)
        probSpam = computeProbs(doc,vocabSpam,freqSpam,megaSpamDocs,nVocab,prior_prob_spam)
        pred[i] = classify(probLegit,probSpam)
        
    evaluate(reference,pred)
    
def computeProbs(doc,vocabSourceDoc,freqSourceDoc,mega,nVocab,priorProb):  
    freqTarget = freqDoc(doc,vocabSourceDoc,freqSourceDoc)
    probDoc =[float (f)/ (len(mega) + len(nVocab)) for f in freqTarget]    
    prob = [math.log10(f) for f in probDoc]
    prob = reduce(lambda x,y: x+y, prob) + math.log10(priorProb)
    return prob

def classify(probLegit,probSpam):
    if(probLegit >= probSpam):
        pred = 1
    else:
        pred = 0
    return pred

def evaluate(reference, pred):    
    print "%20s%20s" % ("Predictions:",pred)
    print "\nEVALUATION"
    print("Accuracy  = " , accuracy(reference,pred))
    #pos_ref = [ref for ref in reference if ref==1]
    true_pos = [pred[i] for i in range(len(pred)) if pred[i]== reference[i]==1]
    false_pos = [pred[i] for i in range(len(pred)) if pred[i]== 1 and reference[i]==0]
    #true_neg = [pred[i] for i in range(len(pred)) if pred[i]== reference[i]==0]
    false_neg = [pred[i] for i in range(len(pred)) if pred[i]== 0 and reference[i]==1]
    precision =  float (len(true_pos)) / (len(true_pos) + len(false_neg))
    recall =  float (len(true_pos)) / (len(true_pos) + len(false_pos))    
    f_measure = float (2 * precision * recall) / (precision + recall)
    
    print("Precision = " , precision)
    print("Recall    = " , recall)
    print("F_measure = " , f_measure)
    

def megaDocument(docs):
    mega = ""
    for d in docs:
        file = open(d,"r")
        data = file.read()    
        mega += data
    return mega

def freqDoc(doc,vocabSourceDoc,freqSourceDoc):
    freqsDoc = [1 for j in range(len(doc))]
    for j in range(len(doc)):
        for i in range(len(vocabSourceDoc)):
            if(vocabSourceDoc[i] == doc[j]):
                freqsDoc[j] += freqSourceDoc[i]
    return freqsDoc

if __name__ == "__main__":
    spamClassifier(); 