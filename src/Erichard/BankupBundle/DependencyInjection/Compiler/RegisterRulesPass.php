<?php

namespace Erichard\BankupBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterRulesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('erichard_bankup.rules_manager')) {
            return;
        }

        $managerDef = $container->getDefinition('erichard_bankup.rules_manager');

        foreach ($container->findTaggedServiceIds('erichard_bankup.rule') as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $priority = $attributes['priority'] ?: 10;
                $managerDef->addMethodCall('addRule', array(new Reference($id), $priority));
            }
        }
    }
}
