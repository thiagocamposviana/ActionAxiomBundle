<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Transform;

class TokenAppearanceCount
{
    public function __invoke($tokenCountByDocument)
    {
        $transform = array();
        foreach ($tokenCountByDocument as $documents) {
            foreach ($documents as $document) {
                foreach ($document as $token => $count) {
                    if ($count > 0) {
                        if (!isset($transform[$token])) {
                            $transform[$token] = 0;
                        }
                        $transform[$token]++;
                    }
                }
            }
        }

        return $transform;
    }
}
