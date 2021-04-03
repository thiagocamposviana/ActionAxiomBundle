<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Token;

class Stopword implements NormalizerInterface
{
    /**
     * An array of words to filter
     * @var array
     */
    protected $stopwords;
    /**
     * Create the normalizer from an array of stopwords
     * @param array $stopwords The array of stopwords
     */
    public function __construct(array $stopwords)
    {
        $this->stopwords = $stopwords;
    }
    /**
     * {@inheritdoc}
     */
    public function normalize(array $tokens)
    {
        return array_diff($tokens, $this->stopwords);
    }
}
