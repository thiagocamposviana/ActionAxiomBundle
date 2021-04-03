<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Token;

use Porter as PorterStemmer;

class Porter implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize(array $tokens)
    {
        return array_map(
            function ($token) {
                return PorterStemmer::Stem(strtolower($token));
            },
            $tokens
        );
    }
}
