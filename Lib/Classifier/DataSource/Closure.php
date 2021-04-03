<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\DataSource;

class Closure extends DataArray
{
    /**
     * @var callable
     */
    protected $closure;
    /**
     * @param callable $closure
     */
    public function __construct(\Closure $closure)
    {
        $this->closure = $closure;
    }
    /**
     * @{inheritdoc}
     */
    public function read()
    {
        return $this->closure->__invoke();
    }
}
