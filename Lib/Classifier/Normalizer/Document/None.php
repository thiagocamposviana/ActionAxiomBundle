<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Document;

class None implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($document)
    {
        return $document;
    }
}
