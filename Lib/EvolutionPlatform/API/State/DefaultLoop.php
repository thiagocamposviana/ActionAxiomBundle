<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\State;

use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\State;


/**
 * Solid/EvolutionaryAlgorithm.py logic
 * https://github.com/100/Solid/blob/master/Solid/EvolutionaryAlgorithm.py
 */
class DefaultLoop extends State
{

    /**
     * This will execute when the state is entered
     * @param type $owner
     * @return void
     */
    public function enter($owner): void {
        $owner->_clear();
        $owner->population = $owner->initialPopulation();
        $owner->populateFitness();
        $mostFit = $owner->mostFit();
        $owner->bestMember = $mostFit[0];
        $owner->bestFitness = $mostFit[1];
    }

    /**
     * this is the states normal update function
     * @param type $owner
     * @return void
     */
    public function  execute($owner) : void {
        $num_copy = max(intval((1 - $owner->crossoverRate) * count($owner->population)), 2);
        $numcrossover = count($owner->population) - $num_copy;
        for( $i = 0; $i < $owner->maxSteps; $i++ )
        {
            $owner->curSteps += 1;

            // lets always print this for now
            print($owner);

            $owner->population = $owner->_select_n($num_copy);
            $owner->populateFitness();
            $parent = null;

            for( $x = 0; $x < $numcrossover; $x++)
            {
                $parents = $owner->_select_n(2);
                $owner->population[] = $owner->crossover($parents[0], $parents[1]);
            }

            $newPopulation = [];
            foreach( $owner->population as $member )
            {
                $newPopulation[] = $owner->mutate($member);
            }
            $owner->population = $newPopulation;

            $owner->populateFitness();
            $mostFit = $owner->mostFit();
            $bestMember = $mostFit[0];
            $bestFitness = $mostFit[1];

            if( $bestFitness > $owner->bestFitness )
            {
                $owner->bestFitness = $bestFitness;
                $owner->bestMember = clone $bestMember;
            }

            if( $owner->maxFitness !== null && $owner->bestFitness >= $owner->maxFitness )
            {
                print("TERMINATING - REACHED MAXIMUM FITNESS\n\n");
                $owner->getFSM()->changeState(null);
            }
        }
        print("TERMINATING - MAX STEPS\n\n");
        $owner->getFSM()->changeState(null);
    }

    /**
     * 
     * @param type $owner
     * @return void
     */
    public function exit($owner) : void {
        $owner->quit();
        print($owner);
        print("TERMINATING - REACHED MAXIMUM STEPS\n\n");
    }

}
