<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API;

abstract class Member
{
    protected float $fitness;
    protected array $data;

    function __construct( array $data ) {
        $this->data = $data;
    }

    public function getFitness() : float
    {
        return $this->fitness;
    }

    public function setFitness( float $fitness )
    {
        $this->fitness = $fitness;
    }

    public function getData() : array
    {
        return $this->data;
    }

    public function setData( array $data )
    {
        $this->data = $data;
    }
}