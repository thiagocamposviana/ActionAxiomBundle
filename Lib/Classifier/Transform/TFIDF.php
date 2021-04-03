<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Transform;

class TFIDF
{
    public function __invoke(
        $tokenCountByDocument,
        $documentCount,
        $tokenAppreanceCount
    ) {
        foreach ($tokenCountByDocument as $category => $documents) {
            foreach ($documents as $documentModel => $document) {
                foreach ($document as $token => $count) {
                    $tokenCountByDocument
                        [$category]
                        [$documentModel]
                        [$token] = log($count + 1, 10) * log(
                            $documentCount / $tokenAppreanceCount[$token],
                            10
                        );
                }
            }
        }

        return $tokenCountByDocument;
    }
}
