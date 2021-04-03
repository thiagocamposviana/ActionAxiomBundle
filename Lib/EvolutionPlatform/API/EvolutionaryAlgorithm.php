<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API;

/**
 * Conducts evolutionary algorithm
 */
abstract class EvolutionaryAlgorithm
{

    // @var Member[]
    public ?array $population = null;
    public ?float $bestFitness = null;
    public ?Member $bestMember = null;

    public ?array $fitnesses = null;

    public float $crossoverRate;

    public float $mutationRate;

    public ?int $curSteps = null;

    public int $maxSteps;
    public $maxFitness = null;
    protected ?State $initialState;
    protected StateMachine $m_pStateMachine;
    protected bool $interrupted = false;

    /**
     * @param float $crossoverRate probability of crossover
     * @param float $mutationRate probability of mutation
     * @param int $maxSteps maximum steps to run genetic algorithm for
     * @param int|float|null $maxFitness fitness value to stop algorithm once reached
     * @param State $initialState the instance of the initial state
     * @throws \Exception
     */
    function __construct(float $crossoverRate, float $mutationRate, int $maxSteps, $maxFitness = null, ?State $initialState = null)
    {

        if( 0 <= $crossoverRate && $crossoverRate  <= 1 )
        {
            $this->crossoverRate = $crossoverRate;
        }
        else
        {
           throw new \Exception('Crossover rate must be a float between 0 and 1');
        }



        if( 0 <= $mutationRate && $mutationRate  <= 1 )
        {
            $this->mutationRate = $mutationRate;
        }
        else
        {
            throw new \Exception('Mutation rate must be a float between 0 and 1');
        }


        if( is_int($maxSteps) && $maxSteps > 0 )
        {
            $this->maxSteps = $maxSteps;
        }
        else
        {
            throw new \Exception('Maximum steps must be a positive integer');
        }

        if( $maxFitness !== null )
        {
            if( is_float($maxFitness) || is_int($maxFitness) )
            {
                $this->maxFitness = floatval($maxFitness);
            }
            else
            {
                throw new \Exception('Maximum fitness must be a numeric type');
            }
        }
        if( $initialState === null )
        {
            $initialState = State\DefaultLoop::getInstance();
        }
        $this->initialState = $initialState;
    }
    public function __toString() : string {
        return sprintf(
                "EVOLUTIONARY ALGORITHM: \n" .
                "CURRENT STEPS: %d \n" .
                "BEST FITNESS: %f \n",
                $this->curSteps, $this->bestFitness);
    }

    /**
     * Resets the variables that are altered on a per-run basis of the algorithm
     * @return void
     */
    public function _clear() : void
    {
        $this->curSteps = 0;
        $this->population = null;
        $this->fitnesses = null;
        $this->bestMember = null;
        $this->bestFitness = null;
    }


    /**
     * Generates initial population
     * @return array list of members of population
     */
    abstract public function initialPopulation() : array;


    /**
     * Evaluates fitness of a given member
     * @param Member $member a member
     * @return float fitness of a given member
     */
    abstract public function fitness( Member $member) : float;

    /**
     * Calculates fitness of all members of current population
     * @return void
     */
    public function populateFitness() : void
    {
        $results = [];
        foreach( $this->population as $member )
        {
            $results[] = $this->fitness($member);
        }
        $this->fitnesses = $results;
    }

    /**
     * Finds most fit member of current population
     * @return array most fit member and most fit member's fitness
     */
    public function mostFit() : array
    {
        $best_idx = 0;
        $cur_idx = 0;
        foreach( $this->fitnesses as $x )
        {
            if ($x > $this->fitnesses[$best_idx])
            {
                $best_idx = $cur_idx;
            }

            $cur_idx += 1;
        }

        return [ $this->population[$best_idx], $this->fitnesses[$best_idx] ];
    }

    /**
     * Probabilistically selects n members from current population using
     * roulette-wheel selection
     * @param int $n number of members to select
     * @return array members
     */
    public function _select_n(int $n) : array
    {
        shuffle($this->population);
        $totalfitness = array_sum($this->fitnesses);
        if( $totalfitness != 0 )
        {
            //$probs = list([$this->fitness(x) / totalfitness for x in $this->population]);
            $probs = [];
            foreach( $this->population as $member )
            {
                $probs[] = $this->fitness($member) / $totalfitness;
            }
            $res = [];
            //for _ in range(n):
            for($z = 0; $z < $n; $z++)
            {
                $r = mt_rand() / mt_getrandmax();
                $sum_ = 0;
                // for i, x in enumerate(probs):
                foreach($probs as $i => $x)
                {
                    $sum_ += $probs[$i];
                    if( $r <= $sum_ )
                    {
                        $res[] = clone $this->population[$i];
                        break;
                    }
                }
            }
            return $res;
        }
        else
        {
            return array_slice($this->population, 0, $n);
        }
    }

    /**
     * Creates new member of population by combining two parent members
     * @param Member $parent1
     * @param Member $parent2
     * @return Member made by combining elements of both parents
     */
    abstract public function crossover(Member $parent1, Member $parent2) : Member;


    /**
     * Randomly mutates a member
     * @param Member a member
     * @return Member a mutated member
     */
    abstract public function mutate(Member $member) : Member;

    /**
     * Marks execution to be interrupted
     * @return void
     */
    public function quit() : void
    {
        $this->interrupted = true;
    }


    /**
     * Conducts evolutionary algorithm
     * @return array best state and best objective function value
     */
    public function run() : array
    {
        $this->m_pStateMachine = new StateMachine($this);
        $this->m_pStateMachine->changeState($this->initialState);

        while(!$this->interrupted && $this->m_pStateMachine->getCurrentState() !== null)
        {
            $this->m_pStateMachine->update();
        }

        return [$this->bestMember, $this->bestFitness];
    }

    public function getFSM() : StateMachine
    {
        return $this->m_pStateMachine;
    }
}