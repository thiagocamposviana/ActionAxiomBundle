<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Transform;

class DocumentTokenCounts
{
    public function __invoke($data)
    {
        $transform = array();

        foreach ($data as $category => $documents) {
            $transform[$category] = 0;
            foreach ($documents as $document) {
                $transform[$category] += count($document);
            }
        }

        return $transform;
    }
}
