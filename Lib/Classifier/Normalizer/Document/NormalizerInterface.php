<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Normalizer\Document;

interface NormalizerInterface
{
    /**
     * Makes document more consistent by a particular method.
     *
     * @param  string $document The document to normalize
     * @return string The normalized document
     */
    public function normalize($document);
}
