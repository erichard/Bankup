<?php

namespace Erichard\BankupBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ErichardBankupExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('rules.yml');

        foreach ($config['banks'] as $bankConnectionName => $bankOption) {
            $this->loadBankConnection($bankConnectionName, $bankOption, $container);
        }
    }

    private function loadBankConnection($name, array $options, ContainerBuilder $container)
    {
        $id = sprintf('erichard_bankup.bank.%s', $name);

        $definition = new DefinitionDecorator('erichard_bankup.bank');
        $definition->replaceArgument(0, $name);
        $definition->replaceArgument(1, $options);
        $definition->addTag('erichard_bankup.bank');

        $container->setDefinition($id, $definition);
    }
}
