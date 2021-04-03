<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API;

interface FitnessEvaluatorInterface
{
    public function evaluate( array $params ) : array;
}
