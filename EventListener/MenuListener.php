<?php

namespace Mugo\ActionAxiomBundle\EventListener;

use EzSystems\EzPlatformAdminUi\Menu\Event\ConfigureMenuEvent;
use EzSystems\EzPlatformAdminUi\Menu\MainMenuBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class MenuListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }
    public static function getSubscribedEvents() : array
    {
        return [ConfigureMenuEvent::MAIN_MENU => 'onMainMenuBuild'];
    }

    public function onMainMenuBuild(ConfigureMenuEvent $event): void
    {
        //if (!$this->authorizationChecker->isGranted('evolution_platform:read')) {
        //    return;
        //}
        $menu = $event->getMenu();
        $menu->addChild(
            'evolution_platform',
            [
                'route' => 'evolution_platform.manage'
            ]
        )
        ->setLabel('Evolution Platform');
    }
}