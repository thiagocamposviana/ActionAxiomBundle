<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API;

// No generics, so instead of State<T>, use make it simply State
/**
 * State Class
 */
class State extends Singleton
{
    /*
     * And instead of function parameter having a strict parameter we make it
     * not restricted, example, instead of:
     * public function Enter(T $owner): void { }
     * we make:
     * public function Enter($owner): void { }
     */
    
    /**
     * This will execute when the state is entered
     * @param type $owner
     * @return void
     */
    public function enter($owner): void { }

    /**
     * this is the states normal update function
     * @param type $owner
     * @return void
     */
    public function  execute($owner) : void { }

    /**
     * 
     * @param type $owner
     * @return void
     */
    public function exit($owner) : void { }

}
