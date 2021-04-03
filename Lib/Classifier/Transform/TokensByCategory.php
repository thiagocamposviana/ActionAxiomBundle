<?php


namespace Mugo\ActionAxiomBundle\Lib\Classifier\Transform;

class TokensByCategory
{
    public function __invoke($tokenCountbyDocument)
    {
        $transform = array();

        foreach ($tokenCountbyDocument as $category => $documents) {
            $transform[$category] = array();
            foreach ($documents as $document) {
                foreach (array_keys($document) as $token) {
                    if (array_key_exists($token, $transform[$category])) {
                        $transform[$category][$token] += $document[$token];
                    } else {
                        $transform[$category][$token] = $document[$token];
                    }
                }
            }
        }

        return $transform;
    }
}
