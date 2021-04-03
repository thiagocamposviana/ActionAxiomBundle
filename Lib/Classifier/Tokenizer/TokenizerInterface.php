<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Tokenizer;

interface TokenizerInterface
{
    /**
     * Split document into tokens
     * @param  string $document The document to split
     * @return array  An array of tokens
     */
    public function tokenize($document);
}
