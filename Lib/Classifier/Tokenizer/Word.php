<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Tokenizer;

class Word implements TokenizerInterface
{
    /**
     * @{inheritdoc}
     */
    public function tokenize($document)
    {
        return preg_split('/\PL+/u', $document, null, PREG_SPLIT_NO_EMPTY);
    }
}
