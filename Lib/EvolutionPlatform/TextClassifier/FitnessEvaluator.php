<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\TextClassifier;

use \Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\FitnessEvaluatorInterface;
use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\Singleton;

class FitnessEvaluator  extends Singleton implements FitnessEvaluatorInterface
{
    public function evaluate( array $params ) : array
    {
        // TODO validate arguments
        $classifier = $params['classifier'];
        $data = $params['data'];
        $results = [];
        $errors = [];
        $correctResults = 0;
        $totalTests = 0;
        foreach( $data as $expectedClassification => $items )
        {
            foreach( $items as $item )
            {
                $classification = $classifier->classify($item);
                if( $classifier->classify($item) == $expectedClassification )
                {
                    $correctResults++;
                }
                else
                {
                    $errors[] = [
                        'expected' => $expectedClassification,
                        'classification' => $classification,
                        'item' => $item,
                        //'results' => $classifier->getResults($item)
                    ];
                }
                $totalTests++;
            }
        }
        $results[] = [
            'accuracy' => $correctResults/$totalTests,
            'errors' => $errors
        ];

        return $results;
    }
}
