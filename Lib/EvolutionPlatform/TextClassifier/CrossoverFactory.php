<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\TextClassifier;

use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\CrossoverFactory as CrossoverFactoryInterface;
use Mugo\ActionAxiomBundle\Lib\Classifier\DataSource\DataArray;
use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\Member as AbstractMember;
use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\Singleton;

class CrossoverFactory extends Singleton implements CrossoverFactoryInterface
{
    public function crossover(AbstractMember $parent1, AbstractMember $parent2) : AbstractMember
    {
        $source = new DataArray();

        $dataSource = [
            'definition' => array_unique( array_merge( $parent1->getData()['definition'], $parent2->getData()['definition'] ) ),
            'other' => array_unique( array_merge( $parent1->getData()['other'], $parent2->getData()['other'] ) ),
        ];
        // mixing and removing a few data to make descendents unique
        foreach( $dataSource as $category => $items )
        {
            shuffle($dataSource[$category]);
            $dataSource[$category] = array_slice($dataSource[$category], floor( ( count( $dataSource[$category] ) / 4 ) ));
        }

        return MemberFactory::getInstance()->create($dataSource);
    }
}