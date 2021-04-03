<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\TextClassifier;

use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\MutationFactory as MutationFactoryInterface;
use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\Member as AbstractMember;
use Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API\Singleton;

class MutationFactory extends Singleton implements MutationFactoryInterface
{
    protected int $mutateExtraDefinitions = 2;

    public function mutate(AbstractMember $member) : AbstractMember
    {
        $newData = MemberFactory::getTextData();
        $memberData = $member->getData();
        $dataSource = [
            'definition' => array_merge( $memberData['definition'], $newData['definition'] ),
            'other' => array_merge( $memberData['other'], $newData['other'] ),
        ];
        for( $x = 0; $x < $this->mutateExtraDefinitions; $x++ )
        {
            $dataSource['definition'][] = MemberFactory::getTextData(true);
        }
        return MemberFactory::getInstance()->create($dataSource);
    }
}