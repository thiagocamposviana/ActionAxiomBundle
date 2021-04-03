<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API;

// No generics, so instead of StateMachine<T>, use make it simply StateMachine
// And instead of function parameter having a strict parameter we make it
// not restricted, example, instead of:
// public function Enter(T $owner): void { }
// we make:
// public function Enter($owner): void { }

class StateMachine
{

    // a pointer to the agent that owns this instance
    private $owner;

    private ?State $currentState;

    // @var a record of the last state the agent was in
    private ?State $previousState;

    // @var this is called every time the FSM is updated
    private ?State $globalState;


    function __construct($owner)
    {
        $this->owner = $owner;
        $this->currentState = null;
        $this->previousState = null;
        $this->globalState = null;

    }

    //public ~StateMachine() { }

    /**
     * Use these methods to initialize the FS
     * @param \Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\State $s
     * @return void
     */
    public function setCurrentState(State $s) : void 
    {
        $this->currentState = $s;
    }

    public function setGlobalState($s) : void
    {
        $this->globalState = $s;
    }

    public function setPreviousState($s) : void
    {
        $this->previousState = $s;
    }

    /**
     * Call this to update the FSM
     * @return void
     */
    public function update() : void
    {
        // if a global state exists, call its execute method, else do nothing
        if ($this->globalState != null) $this->globalState->execute($this->owner);

        // same for the current state
        if ($this->currentState != null) $this->currentState->execute($this->owner);
    }

    /*
    bool  HandleMessage(OgreRefApp::ApplicationObject::CollisionInfo& msg)const
    {
        //first see if the current state is valid and that it can handle
        //the message

        std::cout << "currentState->OnMessage(owner, msg)" << std::endl;

        if (currentState && currentState->OnMessage(owner, msg))
        {
            return true;
        }
        std::cout << "globalState->OnMessage(owner, msg)" << std::endl;
        //if not, and if a global state has been implemented, send
        //the message to the global state
        if (globalState && globalState->OnMessage(owner, msg))
        {
            return true;
        }

        return false;
    }
     * */

    /**
     * Change to a new state
     * @param \Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\State $pNewState
     * @return void
     */
    public function changeState(?State $pNewState) : void
    {

        //keep a record of the previous state
        $this->previousState = $this->currentState;

        //call the exit method of the existing state
        if ($this->currentState != null) $this->currentState->exit($this->owner);

        //change state to the new state
        $this->currentState = $pNewState;

        //call the entry method of the new state
        if ($this->currentState != null) $this->currentState->enter($this->owner);
    }

    /**
     * Change state back to the previous state
     * @return void
     */
    public function revertToPreviousState() : void
    {
        $this->changeState($this->previousState);
    }

    /**
     * @param \Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\State $st
     * @return bool true if the current state's type is equal to the type of the
     */
    public function isInState(State $st) : bool
    {
        if (class_name($this->currentState) == class_name($st))
        {
            return true;
        }
        return false;
    }

    public function getCurrentState(): ?State
    {
        return $this->currentState;
    }

    public function getGlobalState() : ?State
    {
        return $this->globalState;
    }

    public function getPreviousState() : ?State
    {
        return $this->previousState;
    }

    /**
     * Only ever used during debugging to grab the name of the current state
     * @return string
     */
    public function getNameOfCurrentState() : string
    {
        return get_class($this->currentState);
    }
    
}
