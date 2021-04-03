<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\TextClassifier\State;

use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\State;


/**
 * Slightly different from Solid 100 loop
 * Favors Best Member for crossover
 */
class LoopT1 extends State
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
                // different from Solid logic
                // always use best member
                do {
                    $parent = $owner->_select_n(1)[0];
                } while (json_encode($parent->getData()) == json_encode($owner->bestMember->getData()));
                $owner->population[] = $owner->crossover($owner->bestMember, $parent);
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
                return;
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
