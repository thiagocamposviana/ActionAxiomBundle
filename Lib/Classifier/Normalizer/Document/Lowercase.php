<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Document;

class Lowercase implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($document)
    {
        return mb_strtolower($document, 'utf-8');
    }
}
