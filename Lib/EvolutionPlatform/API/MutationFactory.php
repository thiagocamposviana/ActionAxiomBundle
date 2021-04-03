<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API;

interface MutationFactory
{
    public function mutate(Member $member) : Member;
}