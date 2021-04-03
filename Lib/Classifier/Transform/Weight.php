<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Transform;

class Weight
{
    public function __invoke($data)
    {
        foreach ($data as $category => $tokens) {
            foreach ($tokens as $token => $value) {
                $data[$category][$token] = log($value, 10);
            }
        }

        return $data;
    }
}
