<?php
namespace Acme\Bundle\WebBundle\EventListener;

use Sylius\Bundle\WebBundle\Event\MenuBuilderEvent;

class MenuBuilderListener
{
    public function addBackendMenuItems(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();

        $menu['configuration']->addChild('magasins', array(
            'route' => 'sylius_backend_magasin_index',
            'labelAttributes' => array('icon' => 'glyphicon glyphicon-stats'),
        ))->setLabel('Magasin');
        
        $menu['configuration']->addChild('periods', array(
            'route' => 'sylius_backend_period_index',
            'labelAttributes' => array('icon' => 'glyphicon glyphicon-stats'),
        ))->setLabel('Period');
        
        $menu['configuration']->addChild('plannings', array(
            'route' => 'sylius_backend_planning_index',
            'labelAttributes' => array('icon' => 'glyphicon glyphicon-stats'),
        ))->setLabel('Planning');
    }
}
