import numpy as np
import matplotlib.pyplot as plt

from cs224d.dataUtility import *
from q1_softmax import softmax
from q3_sgd import load_saved_params, sgd
from q4_softmaxreg import softmaxRegression, getSentenceFeature, accuracy, softmax_wrapper


def getSentiment():
    
    dataSet = StanfordSentiment()    
    tokens = dataSet.tokens()    
    
    # Load the word vectors we trained earlier 
    _, wordVectors, _ = load_saved_params()
    dimVectors = wordVectors.shape[1]
    
    # Load the test sentences
    sentences = dataSet.getTestSentences() 
    print sentences
    nSentences = len(sentences) 
    sentenceFeatures = np.zeros((nSentences, dimVectors))
    sentenceLabels = np.zeros((nSentences,), dtype=np.int32)
    for i in xrange(nSentences):
        words, sentenceLabels[i] = sentences[i]
        #print sentences[i]
        #print words
        #print sentenceLabels[i]
        sentenceFeatures[i, :] = getSentenceFeature(tokens, wordVectors, words)    
    
    #train weights
    random.seed(3141)
    np.random.seed(59265)
    weights = np.random.randn(dimVectors, nSentences)    
    regularization = 0.00001
    weights = sgd(lambda weights: softmax_wrapper(sentenceFeatures, sentenceLabels, 
        weights, regularization), weights, 3.0, 10, PRINT_EVERY=10)
    
    #pred = np.sum((weights * sentenceFeatures.T).T, axis = 1)
    #pred = softmax(pred)
    #testAccuracy = accuracy(sentenceLabels, pred)
    
    prob = softmax(sentenceFeatures.dot(weights))
    #prob = normalizeRows(prob)
    _, _, pred = softmaxRegression(sentenceFeatures, sentenceLabels, weights)
    pred = 1 / (1 + np.exp(-pred))
    
    #for polarity in pred:
        #print categorify(polarity)
    #_, _, pred = softmaxRegression(sentenceFeatures, sentenceLabels, weights)
    for label in pred:
        print categorify(label)
    #pred = categorify(pred)
    print prob
    print pred

   
def categorify(label):
    if label >= 0.6:
        return "Positive"
    else:
        return "Negative"


if __name__ == "__main__":
    getSentiment();
   # your_sanity_checks();
   
