<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\TextClassifier;

use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\MutationFactory as MutationFactoryInterface;
use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\Member as AbstractMember;
use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\Singleton;

class IntrospectionFactory extends Singleton implements MutationFactoryInterface
{
       
    private function testWithoutItem($data, $category, $item)
    {
        $position = array_search($item, $data[$category]);
        unset($data[$category][$position]);
        return MemberFactory::getInstance()->create($data);
    }

    private function testInOtherCategoryItem($data, $currentCategory, $item)
    {
        $bestState = null;
        $position = array_search($item, $data[$currentCategory]);
        unset($data[$currentCategory][$position]);
        foreach( $data as $category => $items )
        {
            if( $category != $currentCategory )
            {
                $testData = $data;
                $testData[$category][] = $item;
                $testState = MemberFactory::getInstance()->create($testData);
                if( !$bestState || $bestState->getFitness() <  $testState->getFitness() )
                {
                    $bestState = $testState;
                }
            }
        }
        return $bestState;
    }


    public function mutate( AbstractMember $member ) : AbstractMember
    {
        $simulations = 0;
        $dataSource = $member->getData();
        $bestState = clone $member;
        foreach(  $dataSource as $category => $items )
        {
            // control introspections according to the fitness
            $maxCategorySimulations = max( round($bestState->getFitness() * (isset(Settings::$introspectionMaxSimulations[$category]) ? Settings::$introspectionMaxSimulations[$category] : 2)), 1);
            $items = array_reverse($items);
            foreach( $items as $item )
            {
                // try without item in the current category
                $noItem = count($bestState->getData()[$category]) > 1 ? $this->testWithoutItem($bestState->getData(), $category, $item) : null;
                // try with member in other categories
                $otherCategory = count($bestState->getData()[$category]) > 1 ? $this->testInOtherCategoryItem($bestState->getData(), $category, $item) : null;
                if( $noItem !== null && $bestState->getFitness() <  $noItem->getFitness() )
                {
                    $bestState = $noItem;
                }
                if( $otherCategory !== null && $bestState->getFitness() <  $otherCategory->getFitness() )
                {
                    $bestState = $otherCategory;
                }
                $simulations++;
                if( $simulations >= $maxCategorySimulations )
                {
                    $simulations = 0;
                    break;
                }
            }
        }
        return $bestState;
    }
}