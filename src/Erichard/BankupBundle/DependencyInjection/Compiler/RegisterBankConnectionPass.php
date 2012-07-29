<?php

namespace Erichard\BankupBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterBankConnectionPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('erichard_bankup.manager')) {
            return;
        }

        $managerDef = $container->getDefinition('erichard_bankup.manager');

        foreach ($container->findTaggedServiceIds('erichard_bankup.bank') as $id => $tags) {
            foreach ($tags as $tag) {
                $managerDef->addMethodCall('registerBank', array(new Reference($id)));
            }
        }
    }
}
