<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Transform;

class DocumentCount
{
    public function __invoke($data)
    {
        $count = 0;
        foreach ($data as $docs) {
            $count += count($docs);
        }

        return $count;
    }
}
