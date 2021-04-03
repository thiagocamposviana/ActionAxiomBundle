<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Transform;

class Complement
{
    public function __invoke(
        $documentLength,
        $tokensByCategory,
        $documentCount,
        $documentTokenCounts
    ) {
        $cats = array_keys($tokensByCategory);
        $trans = array();

        $tokByCatSums = array();

        foreach ($tokensByCategory as $cat => $tokens) {
            $tokByCatSums[$cat] = array_sum($tokens);
        }

        $documentCounts = array();

        foreach ($documentLength as $cat => $documents) {
            $documentCounts[$cat] = count($documents);
        }

        foreach ($tokensByCategory as $cat => $tokens) {

            $trans[$cat] = array();
            $categoriesSelection = array_diff($cats, array($cat));

            $docsInOtherCats = $documentCount - $documentCounts[$cat];

            foreach (array_keys($tokens) as $token) {
                $trans[$cat][$token] = $docsInOtherCats;
                foreach ($categoriesSelection as $currCat) {
                    if (array_key_exists($token, $tokensByCategory[$currCat])) {
                        $trans[$cat][$token] += $tokensByCategory[$currCat][$token];
                    }
                }
                foreach ($categoriesSelection as $currCat) {
                    $trans[$cat][$token] =
                        $trans[$cat][$token]
                        /
                        ($tokByCatSums[$currCat] + $documentTokenCounts[$currCat]);
                }

            }

        }

        return $trans;
    }
}
