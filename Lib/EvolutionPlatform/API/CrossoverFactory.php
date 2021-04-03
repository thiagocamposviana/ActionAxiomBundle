<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API;

interface CrossoverFactory
{
    public function crossover(Member $parent1, Member $parent2) : Member;
}