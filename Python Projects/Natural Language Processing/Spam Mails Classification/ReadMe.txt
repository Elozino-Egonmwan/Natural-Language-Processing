ASS2_SPAMCLASSIFICATION

Data used for training was collected from the Ling-Spam corpus, as described in the 
paper:

I. Androutsopoulos, J. Koutsias, K.V. Chandrinos, George Paliouras,and C.D. Spyropoulos,
"An Evaluation of Naive Bayesian Anti-Spam Filtering". 
In Potamias, G., Moustakis, V. and van Someren, M. (Eds.), 
Proceedings of the Workshop on Machine Learning in the New Information Age,
11th European Conference on Machine Learning (ECML 2000), 
Barcelona, Spain, pp. 9-17, 2000.

TRAINING SET

There are 6 documents in the training set, each prefixed with "train_"
There are 3 documents in the training set that are legit (ie not spam) and are prefixed with "train_msg"
There are 3 documents in the training set that are spam and are prefixed with "train_spm"

TEST SET
The test set consists of 5 documents prefixed with "test_"
There are 3 spam documents in the test set and are prefixed with "test_spm"
There are 2 legit documents in the test set and are prefixed with "test_msg"


NB:
To classify a new document. Simply:
    -include the file in same directory
    -include the file name in the list of docToClassify in line 31 of the program file- "ass2_spamClassification"
    -include the reference for that file in the list of references in line 32 of the program file - "ass2_spamClassification"
        -reference[i] = 1 iff file[i] is legit
        -reference[i] = 0 iff file[i] is spam