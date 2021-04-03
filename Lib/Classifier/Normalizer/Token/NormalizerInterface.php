<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Token;

interface NormalizerInterface
{
    /**
     * Makes tokens more consistent by a particular method.
     *
     * This is to increase matches across what tokens are deemed equivalent but differnt
     * @param  array $tokens The tokens to normalizer
     * @return array The array of normalized tokens
     */
    public function normalize(array $tokens);
}
