<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API;

class Singleton
{
    // Singleton Pattern
    private static $instances = [];
    protected function __construct() {}
    protected function __clone() {}
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
    /**
     * Singleton Instance
     * @return CrossoverFactory
     */
    public static function getInstance()
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static;
        }
        return self::$instances[$cls];
    }
}