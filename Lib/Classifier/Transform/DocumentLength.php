<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Transform;

class DocumentLength
{
    public function __invoke($tfidf)
    {
        $transform = $tfidf;

        foreach ($tfidf as $category => $documents) {
            foreach ($documents as $documentIndex => $document) {
                $denominator = 0;
                foreach ($document as $count) {
                    $denominator += $count * $count;
                }
                $denominator = sqrt($denominator);
                if ($denominator != 0) {
                    foreach ($document as $token => $count) {
                        $transform
                            [$category]
                            [$documentIndex]
                            [$token] = $count / $denominator;
                    }
                } else {
                    throw new \RuntimeException("Cannot divide by 0 in DocumentLength transform");
                }
            }
        }

        return $transform;
    }
}
