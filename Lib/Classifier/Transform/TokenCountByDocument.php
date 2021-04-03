<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Transform;

class TokenCountByDocument
{
    public function __invoke($data)
    {
        $transform = array();

        foreach ($data as $category => $documents) {
            $transform[$category]  = array();
            foreach ($documents as $tokens) {
                $transform[$category][] = array_count_values($tokens);
            }
        }

        return $transform;
    }
}
