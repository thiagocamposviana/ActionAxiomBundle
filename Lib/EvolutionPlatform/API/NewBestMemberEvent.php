<?php

namespace Mugo\ActionAxiomBundle\Lib\EvolutionPlatform\API;

use Symfony\Component\EventDispatcher\Event;
 
class NewBestMemberEvent extends Event
{
    const NAME = 'EvolutionPlatform.newBestMemberEvent';
 
    protected $member;
 
    public function __construct( Member $member )
    {
        $this->member = $member;
    }
 
    public function getMember()
    {
        return $this->member;
    }
}